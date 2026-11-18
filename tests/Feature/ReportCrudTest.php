<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Category;
use App\Models\Loan;
use App\Models\LoanReport;
use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportCrudTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Member $member;
    protected Book $book;
    protected Loan $loan;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create(['role' => 'petugas']);

        $category = Category::create([
            'nama_kategori' => 'Teknologi Informasi',
            'deskripsi'     => 'Buku-buku komputer dan pemrograman',
        ]);

        $this->book = Book::create([
            'judul'        => 'Pemrograman Web Modern',
            'penulis'      => 'Budi Santoso',
            'penerbit'     => 'PENS Press',
            'tahun_terbit' => 2024,
            'isbn'         => '978-602-0001',
            'stok'         => 5,
            'category_id'  => $category->id,
        ]);

        $this->member = Member::create([
            'nama'          => 'Ahmad Fauzi',
            'nim'           => '2103191001',
            'email'         => 'fauzi@pens.ac.id',
            'nomor_telepon' => '081234567890',
            'alamat'        => 'Surabaya',
            'status'        => 'aktif',
        ]);

        $this->loan = Loan::create([
            'member_id'       => $this->member->id,
            'user_id'         => $this->user->id,
            'tanggal_pinjam'  => now()->subDays(10)->toDateString(),
            'tanggal_kembali' => now()->subDays(3)->toDateString(),
            'status'          => 'terlambat',
        ]);

        $this->loan->loanItems()->create(['book_id' => $this->book->id]);
    }

    public function test_reports_index_can_be_rendered(): void
    {
        $this->actingAs($this->user)
            ->get(route('reports.index'))
            ->assertOk()
            ->assertSee('Laporan Sirkulasi');
    }

    public function test_reports_create_page_loads_with_loan_data(): void
    {
        $this->actingAs($this->user)
            ->get(route('reports.create', ['loan_id' => $this->loan->id]))
            ->assertOk()
            ->assertSeeText($this->member->nama)
            ->assertSeeText('Pemrograman Web Modern');
    }

    public function test_report_can_be_stored_with_reasons_and_fines(): void
    {
        $response = $this->actingAs($this->user)->post(route('reports.store'), [
            'loan_id'             => $this->loan->id,
            'jenis_kejadian'      => 'rusak_ringan',
            'kondisi_buku'        => 'Halaman bab 3 terlipat dan sedikit robek',
            'hari_keterlambatan'  => 3,
            'denda_keterlambatan' => 3000,
            'biaya_ganti_rugi'    => 15000,
            'alasan_keterangan'   => 'Terkena air hujan saat perjalanan ke kampus',
            'tindakan_petugas'    => 'Peminjam membayar ganti rugi perbaikan buku',
            'status_penyelesaian' => 'proses',
            'tanggal_laporan'     => now()->toDateString(),
        ]);

        $this->assertDatabaseHas('loan_reports', [
            'loan_id'        => $this->loan->id,
            'jenis_kejadian' => 'rusak_ringan',
            'total_denda'    => 18000,
        ]);

        $report = LoanReport::first();
        $response->assertRedirect(route('reports.show', $report->id));
    }

    public function test_report_berita_acara_can_be_rendered_for_print(): void
    {
        $report = LoanReport::create([
            'loan_id'             => $this->loan->id,
            'user_id'             => $this->user->id,
            'nomor_laporan'       => 'LAP-202611-0001',
            'jenis_kejadian'      => 'hilang',
            'kondisi_buku'        => 'Buku hilang di perpustakaan luar',
            'hari_keterlambatan'  => 0,
            'denda_keterlambatan' => 0,
            'biaya_ganti_rugi'    => 75000,
            'total_denda'         => 75000,
            'alasan_keterangan'   => 'Buku tertinggal di transportasi umum',
            'tindakan_petugas'    => 'Wajib mengganti buku judul serupa dalam 7 hari',
            'status_penyelesaian' => 'proses',
            'tanggal_laporan'     => now()->toDateString(),
        ]);

        $this->actingAs($this->user)
            ->get(route('reports.show', $report->id))
            ->assertOk()
            ->assertSeeText('BERITA ACARA INSIDEN SIRKULASI PUSTAKA')
            ->assertSeeText('LAP-202611-0001')
            ->assertSeeText('75.000');
    }

    public function test_report_can_be_updated_and_settled(): void
    {
        $report = LoanReport::create([
            'loan_id'             => $this->loan->id,
            'user_id'             => $this->user->id,
            'nomor_laporan'       => 'LAP-202611-0002',
            'jenis_kejadian'      => 'terlambat',
            'kondisi_buku'        => 'Buku dalam kondisi utuh',
            'hari_keterlambatan'  => 3,
            'denda_keterlambatan' => 3000,
            'biaya_ganti_rugi'    => 0,
            'total_denda'         => 3000,
            'alasan_keterangan'   => 'Sakit selama 3 hari',
            'tindakan_petugas'    => 'Membayar denda tunai di kasir',
            'status_penyelesaian' => 'proses',
            'tanggal_laporan'     => now()->toDateString(),
        ]);

        $response = $this->actingAs($this->user)->put(route('reports.update', $report->id), [
            'jenis_kejadian'      => 'terlambat',
            'kondisi_buku'        => 'Buku dalam kondisi utuh',
            'hari_keterlambatan'  => 3,
            'denda_keterlambatan' => 3000,
            'biaya_ganti_rugi'    => 0,
            'alasan_keterangan'   => 'Sakit selama 3 hari, surat dokter terlampir',
            'tindakan_petugas'    => 'Denda telah lunas dibayar',
            'status_penyelesaian' => 'selesai',
        ]);

        $response->assertRedirect(route('reports.show', $report->id));

        $this->assertDatabaseHas('loan_reports', [
            'id'                  => $report->id,
            'status_penyelesaian' => 'selesai',
        ]);

        // Status loan terupdate otomatis menjadi 'dikembalikan'
        $this->assertEquals('dikembalikan', $this->loan->fresh()->status);
    }

    public function test_report_print_all_page_can_be_rendered(): void
    {
        $this->actingAs($this->user)
            ->get(route('reports.print'))
            ->assertOk()
            ->assertSee('Rekapitulasi Laporan Sirkulasi');
    }

    public function test_report_can_be_deleted(): void
    {
        $report = LoanReport::create([
            'loan_id'             => $this->loan->id,
            'user_id'             => $this->user->id,
            'nomor_laporan'       => 'LAP-202611-0003',
            'jenis_kejadian'      => 'lainnya',
            'kondisi_buku'        => 'Cover terlepas',
            'hari_keterlambatan'  => 0,
            'denda_keterlambatan' => 0,
            'biaya_ganti_rugi'    => 5000,
            'total_denda'         => 5000,
            'alasan_keterangan'   => 'Salah penanganan',
            'tindakan_petugas'    => 'Dilem ulang',
            'status_penyelesaian' => 'selesai',
            'tanggal_laporan'     => now()->toDateString(),
        ]);

        $response = $this->actingAs($this->user)->delete(route('reports.destroy', $report->id));

        $response->assertRedirect(route('reports.index'));
        $this->assertDatabaseMissing('loan_reports', ['id' => $report->id]);
    }
}
