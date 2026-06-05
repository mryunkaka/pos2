# Panduan Alur Halaman Lakasir POS

Dokumen ini menjelaskan fungsi tiap halaman di panel tenant/member Lakasir, terutama untuk pemakaian offline di toko fotokopi, ATK, percetakan, sembako, dan F&B.

Alamat lokal saat ini:

```text
http://localhost:8085/member
```

## Ringkasan Alur Utama

Urutan paling mudah dipahami untuk operasional toko:

1. **General Setting**: isi profil toko, mata uang, pajak, dan fitur yang aktif.
2. **Category**: buat kelompok barang/jasa, misalnya ATK, Cetak Foto, Sablon, Sembako, Minuman.
3. **Product**: buat data barang dan jasa yang dijual.
4. **Supplier**: isi pemasok barang.
5. **Purchasing**: catat pembelian/restock dari supplier.
6. **Stock Opname**: hitung stok fisik dan koreksi stok jika ada selisih.
7. **Member**: data pelanggan/member.
8. **Payment Method**: metode pembayaran seperti Cash, QRIS, Transfer, Debit, atau Kredit.
9. **POS / Cashier**: transaksi penjualan harian.
10. **Selling History**: lihat histori transaksi dan cetak invoice/struk.
11. **Receivable**: pantau piutang bila ada transaksi kredit.
12. **Report**: lihat dan cetak laporan penjualan, produk, kasir, dan pembelian.

## Penjelasan Per Halaman untuk Orang Awam

Bayangkan aplikasi ini seperti buku kerja toko. Setiap halaman punya tugas sendiri supaya data barang, pembelian, penjualan, stok, pelanggan, dan laporan tidak tercampur.

| Halaman | Fungsi Sederhana | Contoh Pemakaian |
| --- | --- | --- |
| Dashboard | Halaman awal untuk melihat gambaran umum toko. | Setelah login, pemilik toko melihat ringkasan aktivitas. |
| POS / Cashier | Tempat kasir melayani pembeli dan menyelesaikan transaksi. | Jual pulpen, print CV, cetak foto, air mineral, atau snack. |
| Cart Item | Keranjang sementara sebelum transaksi dibayar. | Mengecek barang yang sudah dimasukkan ke keranjang kasir. |
| Category | Kelompok barang atau jasa. | Membuat kategori ATK, Cetak Foto, Sablon, Sembako, Minuman. |
| Product | Daftar barang dan jasa yang dijual. | Input Pulpen, Kertas HVS, Print Warna, Cetak Spanduk 3x6, Beras, Kopi. |
| Purchasing | Catatan pembelian/restock barang dari supplier. | Toko membeli 20 rim kertas HVS dari supplier. |
| Stock Opname | Tempat koreksi stok berdasarkan hitung fisik. | Sistem mencatat 100 pulpen, fisik hanya 96 pulpen. |
| Supplier | Data pemasok barang. | Supplier ATK, distributor sembako, pemasok minuman. |
| Member | Data pelanggan tetap. | Pelanggan langganan fotokopi atau pelanggan kredit. |
| Payment Method | Daftar cara pembayaran. | Cash, QRIS, Transfer, Debit, Kredit. |
| Selling History | Riwayat transaksi yang sudah selesai. | Cek transaksi kemarin dan cetak ulang struk. |
| Receivable | Daftar piutang pelanggan. | Pelanggan bayar kredit, lalu cicil pembayaran minggu depan. |
| Voucher | Kode diskon untuk transaksi. | Kode `HEMAT10` untuk diskon promo. |
| Table | Nomor meja untuk bisnis F&B. | Meja 1, Meja 2, Take Away. |
| Report | Laporan penjualan, produk, kasir, dan pembelian. | Rekap omzet harian atau laporan pembelian bulanan. |
| General Setting | Pengaturan identitas toko dan fitur aplikasi. | Ubah nama toko, logo, mata uang, pajak, bahasa, timezone. |
| Printer | Pengaturan printer struk. | Pilih printer USB dan tes cetak struk. |
| User | Akun pengguna aplikasi. | Buat akun owner, admin, kasir, atau staff gudang. |
| Role | Kelompok hak akses pengguna. | Kasir hanya boleh transaksi, owner boleh semua. |
| Permission | Izin detail untuk menu dan tombol. | Izin approve purchasing atau akses laporan. |
| Update | Halaman pembaruan aplikasi. | Untuk mode offline, halaman ini bukan alur utama harian. |

Alur paling mudah untuk toko baru:

```text
General Setting -> Category -> Product -> Supplier -> Purchasing -> POS/Cashier -> Report
```

Alur stok yang benar:

```text
Product = stok awal
Purchasing = barang masuk dari supplier
Stock Opname = koreksi stok hasil hitung fisik
POS/Cashier = barang keluar karena dijual
```

## Istilah Tombol Umum

- **Create**: membuat data baru.
- **Edit**: mengubah data yang sudah ada.
- **View**: melihat detail data, biasanya juga tempat menambah item detail.
- **Delete**: menghapus data.
- **Restore**: mengembalikan data yang sebelumnya dihapus lunak.
- **Force Delete**: menghapus permanen.
- **Bulk Action**: aksi untuk banyak baris sekaligus.
- **Update Status**: mengubah tahap proses dokumen, misalnya pembelian atau stock opname.
- **Set Paid / Set Unpaid**: menandai status pembayaran pembelian supplier.

## Dashboard

URL:

```text
/member
```

Dashboard adalah halaman awal setelah login. Fungsinya untuk melihat ringkasan kondisi toko, seperti ringkasan transaksi, aktivitas, atau widget yang tersedia sesuai fitur dan permission akun.

Gunakan halaman ini sebagai pintu masuk, bukan untuk input data master.

## POS / Cashier

URL:

```text
/member/cashier
/member/p-o-s
```

Halaman ini dipakai untuk transaksi penjualan.

Alur kerja:

1. Cari produk atau scan barcode.
2. Masukkan barang ke cart.
3. Atur qty, diskon item, member, voucher, catatan, meja jika fitur F&B dipakai.
4. Pilih metode pembayaran.
5. Untuk pembayaran non-kredit, uang bayar wajib cukup.
6. Untuk pembayaran kredit, member dan jatuh tempo wajib diisi.
7. Selesaikan transaksi.
8. Sistem membuat data penjualan di **Selling History**.
9. Jika transaksi kredit, sistem membuat data di **Receivable**.

Catatan:

- Produk tipe **product** mengurangi stok saat transaksi.
- Produk tipe **service** seperti print CV, cetak foto, desain, atau jasa sablon tidak wajib punya stok.
- Cart bersifat sementara untuk kasir yang sedang login.

## Cart Item

URL:

```text
/member/cart-item
```

Halaman ini menampilkan item yang sedang berada di keranjang transaksi. Biasanya tidak perlu dibuka manual jika transaksi dilakukan dari POS/Cashier.

Gunakan halaman ini bila ingin memeriksa item yang tersangkut di cart.

## Category

URL:

```text
/member/categories
/member/categories/create
/member/categories/{id}/edit
```

Category adalah kelompok produk/jasa. Contoh:

- ATK
- Fotocopy & Print
- Cetak Foto
- Sablon
- Poster & Banner
- Jilid & Laminating
- Sembako
- Minuman
- Makanan Ringan

Alur kerja:

1. Buka **Category**.
2. Klik **Create**.
3. Isi nama kategori.
4. Simpan.
5. Setelah itu kategori bisa dipilih saat membuat produk.

Edit dipakai untuk mengganti nama kategori. Delete dipakai jika kategori tidak dipakai atau tidak diperlukan.

## Product

URL:

```text
/member/products
/member/products/create
/member/products/{id}
/member/products/{id}/edit
/member/products/{id}/print-label
```

Product adalah master barang dan jasa yang dijual.

Contoh barang stok:

- Pulpen, buku tulis, kertas HVS, map, tinta printer.
- Beras, gula, minyak goreng, mie instan.
- Air mineral, teh botol, kopi, snack.

Contoh jasa:

- Fotocopy.
- Print hitam putih / warna.
- Print CV.
- Cetak foto.
- Sablon.
- Cetak poster.
- Cetak spanduk 3x6.
- Jilid dan laminating.

Field penting:

- **Name**: nama produk/jasa.
- **Category**: kelompok produk.
- **Type**: `product` untuk barang stok, `service` untuk jasa.
- **SKU**: kode internal. Bisa dikosongkan jika fitur auto-generate aktif.
- **Barcode**: kode barcode untuk scan.
- **Unit**: satuan, misalnya pcs, rim, lembar, meter, paket, porsi.
- **Initial price**: harga modal.
- **Selling price**: harga jual.
- **Stock**: stok awal, hanya muncul saat create dan hanya relevan untuk tipe `product`.
- **Non stock**: produk tidak dihitung stoknya.
- **Image**: foto produk.

Alur create product:

1. Buka **Product**.
2. Klik **Create**.
3. Pilih category.
4. Pilih type.
5. Isi nama, unit, harga modal, harga jual, dan stok awal jika barang stok.
6. Tambahkan barcode jika perlu.
7. Simpan.

Alur edit product:

1. Buka **Product**.
2. Pilih produk.
3. Klik **Edit**.
4. Ubah nama, kategori, harga, barcode, foto, atau pengaturan lain.
5. Simpan.

Halaman view product:

- Melihat detail produk.
- Melihat relasi stok.
- Melihat histori penjualan produk.
- Mengatur satuan/harga tambahan jika fitur tersedia.
- Menjalankan **Print Label**.
- Menjalankan **Activate / Inactivate** untuk menampilkan atau menyembunyikan produk dari transaksi.

Catatan penting tentang stok di Product:

- Stok di halaman **Product Create** adalah stok awal saat barang pertama kali dibuat.
- Setelah produk sudah ada, penambahan stok yang benar sebaiknya lewat **Purchasing**.
- Koreksi stok karena hasil hitung fisik sebaiknya lewat **Stock Opname**.

## Purchasing

URL:

```text
/member/purchasings
/member/purchasings/create
/member/purchasings/{id}
/member/purchasings/{id}/edit
```

Purchasing adalah dokumen pembelian/restock dari supplier.

Contoh:

- Beli 10 rim kertas HVS dari supplier ATK.
- Beli tinta printer.
- Beli stok beras, gula, mie instan.
- Beli bahan minuman atau snack.

Alur create purchasing:

1. Buka **Purchasing**.
2. Klik **Create**.
3. Pilih supplier.
4. Pilih payment method.
5. Isi tanggal pembelian dan due date.
6. Upload gambar nota jika ada.
7. Simpan.
8. Masuk ke halaman **View Purchasing**.
9. Tambahkan item barang yang dibeli pada bagian stok/detail item.
10. Cek total pembelian.
11. Ubah status sesuai tahap proses.

Status purchasing:

- **pending**: dokumen baru, masih draft.
- **reviewing**: sedang diperiksa.
- **approved**: disetujui dan dikunci.

Tombol di Purchasing:

- **View**: melihat detail pembelian dan menambah item barang.
- **Edit**: mengubah header pembelian seperti supplier, tanggal, dan nota.
- **Set Paid / Set Unpaid**: mengubah status pembayaran supplier.
- **Update Status**: mengubah `pending`, `reviewing`, atau `approved`.
- **Delete**: menghapus dokumen jika belum approved.

Catatan penting:

- Saat status sudah **approved**, dokumen tidak bisa diedit/dihapus dari tombol biasa.
- User perlu permission `approve purchasing` untuk memilih status **approved**.
- Item barang di purchasing menambah/mencatat stok masuk dari supplier.

## Stock Opname

URL:

```text
/member/stock-opnames
/member/stock-opnames/create
/member/stock-opnames/{id}
/member/stock-opnames/{id}/edit
```

Stock Opname adalah proses menghitung stok fisik di toko dan mencocokkannya dengan stok sistem.

Contoh pemakaian:

- Sistem mencatat pulpen 100 pcs, fisik ternyata 96 pcs.
- Sistem mencatat kertas HVS 20 rim, fisik 21 rim.
- Ada barang rusak, hilang, atau salah input.

Alur create stock opname:

1. Buka **Stock Opname**.
2. Klik **Create**.
3. PIC otomatis mengikuti user login.
4. Isi tanggal.
5. Simpan.
6. Masuk ke **View Stock Opname**.
7. Tambahkan item produk yang dihitung.
8. Isi stok aktual/fisik.
9. Sistem menampilkan selisih antara stok sistem dan stok aktual.
10. Ubah status sesuai tahap proses.

Status stock opname:

- **pending**: draft perhitungan.
- **reviewing**: sedang dicek.
- **approved**: disetujui dan dikunci.

Tombol di Stock Opname:

- **View**: melihat detail opname dan item yang dihitung.
- **Edit**: mengubah header opname jika belum approved.
- **Update Status**: mengubah `pending`, `reviewing`, atau `approved`.
- **Delete**: menghapus dokumen jika belum approved dan PIC sesuai user login.

Catatan penting:

- Setelah **approved**, stock opname tidak bisa diedit/dihapus dari tombol biasa.
- User perlu permission `approve stock opname` untuk memilih status **approved**.
- Stock opname bukan pembelian. Ini dipakai untuk koreksi stok berdasarkan hitung fisik.

## Perbedaan Stock di Product, Purchasing, dan Stock Opname

Ini bagian yang sering membingungkan:

| Halaman | Arti stock | Kapan dipakai |
| --- | --- | --- |
| Product Create | Stok awal saat produk baru dibuat | Saat pertama kali input barang |
| Purchasing | Stok masuk dari pembelian supplier | Saat restock barang |
| Stock Opname | Stok fisik hasil hitung ulang | Saat audit/koreksi stok |

Contoh:

1. Pertama kali input **Kertas HVS A4 70gsm**, isi stok awal 5 rim di Product.
2. Besok beli lagi 20 rim dari supplier, input lewat Purchasing.
3. Akhir bulan dihitung fisik ternyata 24 rim, buat Stock Opname untuk koreksi.

## Supplier

URL:

```text
/member/suppliers
/member/suppliers/create
/member/suppliers/{id}/edit
```

Supplier adalah pemasok barang.

Contoh:

- Supplier ATK.
- Distributor kertas.
- Distributor sembako.
- Pemasok minuman/snack.

Alur:

1. Buka **Supplier**.
2. Klik **Create**.
3. Isi nama dan data kontak.
4. Simpan.
5. Supplier dapat dipilih saat membuat Purchasing.

## Member

URL:

```text
/member/members
/member/members/create
/member/members/{id}/edit
```

Member adalah pelanggan yang ingin disimpan datanya.

Dipakai untuk:

- Transaksi pelanggan tetap.
- Transaksi kredit/piutang.
- Riwayat pembelian per pelanggan.

Alur:

1. Buka **Member**.
2. Klik **Create**.
3. Isi nama, email/kontak, dan data lain.
4. Simpan.
5. Saat transaksi POS, pilih member jika diperlukan.

## Payment Method

URL:

```text
/member/payment-methods
/member/payment-methods/create
/member/payment-methods/{id}/edit
```

Payment Method adalah cara pembayaran transaksi.

Contoh:

- Cash.
- QRIS.
- Transfer Bank.
- Debit Card.
- Kredit/Piutang.

Catatan:

- Jika metode pembayaran ditandai sebagai kredit, transaksi POS meminta member dan due date.
- Metode kredit menghasilkan data di **Receivable**.

## Selling History

URL:

```text
/member/sellings
/member/sellings/{id}
```

Selling History adalah daftar transaksi penjualan yang sudah selesai.

Yang bisa dilihat:

- Kode transaksi.
- Kasir.
- Member.
- Nomor pelanggan.
- Tanggal.
- Total harga.
- Pajak.
- Modal dan margin jika fitur harga modal aktif.

Halaman view selling:

- Melihat detail item transaksi.
- Cetak invoice.
- Cetak receipt/struk.

Selling History tidak dipakai untuk membuat transaksi baru. Transaksi baru dibuat dari POS/Cashier.

## Receivable

URL:

```text
/member/receivables
/member/receivables/{id}
```

Receivable adalah piutang pelanggan.

Data ini muncul jika transaksi menggunakan metode pembayaran kredit.

Status:

- **Unpaid**: belum lunas.
- **Paid off**: sudah lunas.

Tombol:

- **View**: melihat detail piutang, item piutang, dan riwayat pembayaran.
- **Add Payment**: menambah pembayaran cicilan/pelunasan. Tombol ini hanya muncul jika piutang belum lunas dan user punya permission.

Alur:

1. Transaksi kredit dibuat dari POS.
2. Data masuk ke Receivable.
3. Saat pelanggan membayar sebagian atau lunas, klik **Add Payment**.
4. Jika sisa piutang nol, status menjadi paid off.

## Voucher

URL:

```text
/member/vouchers
/member/vouchers/create
/member/vouchers/{id}/edit
```

Voucher adalah diskon yang bisa dipakai saat transaksi.

Field penting:

- **Name**: nama promo.
- **Code**: kode voucher yang dimasukkan di POS.
- **Type**: `percentage` atau `flat`.
- **Nominal**: nilai diskon.
- **Kuota**: batas pemakaian.
- **Start date**: tanggal mulai berlaku.
- **Expired**: tanggal berakhir.
- **Minimal buying**: minimal belanja.

Alur:

1. Buat voucher.
2. Pastikan tanggal aktif dan minimal belanja sesuai.
3. Di POS, masukkan kode voucher.
4. Sistem menghitung diskon jika voucher valid.

## Table

URL:

```text
/member/tables
/member/tables/create
/member/tables/{id}/edit
```

Table dipakai untuk bisnis F&B yang membutuhkan nomor meja.

Contoh:

- Meja 1.
- Meja 2.
- Take away.

Jika bisnis bukan F&B, menu ini bisa tersembunyi.

## Report

URL:

```text
/member/report
/member/selling-report
/member/product-report
/member/cashier-report
/member/purchasing-report
```

Report adalah pusat laporan.

Jenis laporan:

- **Selling Report**: laporan penjualan.
- **Product Report**: laporan produk.
- **Cashier Report**: laporan per kasir.
- **Purchasing Report**: laporan pembelian supplier.

Alur umum:

1. Buka laporan.
2. Pilih rentang tanggal.
3. Klik **Generate**.
4. Jika perlu, klik **Print** atau **Download PDF**.

Gunakan laporan untuk rekap harian, mingguan, bulanan, atau pengecekan omzet dan pembelian.

## General Setting

URL:

```text
/member/general-setting
```

General Setting berisi pengaturan toko dan aplikasi.

Tab utama:

- **About**: nama toko, jenis bisnis, lokasi, logo/foto toko.
- **App**: mata uang, minimal stok untuk notifikasi, pajak default.
- **Feature**: mengaktifkan/menonaktifkan fitur seperti supplier, purchasing, receivable, stock opname, voucher, POS V2, import product.
- **Profile**: data user login, email, nomor telepon, alamat, bahasa, timezone, foto profil, dan password.

Catatan:

- Beberapa menu hanya muncul jika fiturnya aktif.
- Beberapa tab hanya bisa dibuka jika user punya permission.
- Untuk offline lokal, pengaturan update online tidak menjadi prioritas.

## Printer

URL:

```text
/member/printer
```

Printer dipakai untuk mengatur printer struk.

Field penting:

- **Header**: teks atas struk.
- **Name**: nama pengaturan printer.
- **Driver**: saat ini USB.
- **Printer / Printer ID**: dipilih dari printer yang terhubung.
- **Footer**: teks bawah struk.

Tombol:

- **Select Printer**: memilih printer lokal.
- **Save**: menyimpan pengaturan.
- **Test**: mencoba cetak.

## User

URL:

```text
/member/users
/member/users/create
/member/users/{id}/edit
```

User adalah akun pengguna sistem.

Contoh:

- Owner.
- Admin.
- Kasir.
- Staff gudang.

Alur:

1. Buat role dulu jika diperlukan.
2. Buka **User**.
3. Klik **Create**.
4. Isi nama, email, password, dan role.
5. Simpan.

## Role

URL:

```text
/member/roles
/member/roles/create
/member/roles/{id}/edit
```

Role adalah kelompok hak akses.

Contoh:

- Owner: semua akses.
- Kasir: POS dan selling history.
- Gudang: product, purchasing, stock opname.
- Admin: master data dan laporan.

Role menentukan menu dan tombol apa yang bisa dilihat user.

## Permission

URL:

```text
/member/permissions
```

Permission adalah daftar hak akses detail.

Biasanya permission tidak sering diubah langsung. Permission lebih sering dipakai saat mengatur role.

Contoh permission penting:

- `create selling`
- `approve purchasing`
- `approve stock opname`
- `access report`
- `access general setting`
- `create receivable payment`

## Update

URL:

```text
/member/update
```

Halaman Update berhubungan dengan pengecekan versi aplikasi.

Untuk mode offline lokal saat ini, update online tidak menjadi alur utama. Fokus operasional offline adalah transaksi, stok, pembelian, dan laporan.

## Alur Harian yang Disarankan

Untuk toko fotokopi/ATK/percetakan/sembako/F&B:

1. Pagi hari, buka POS dan cek printer.
2. Saat ada penjualan, lakukan dari POS/Cashier.
3. Jika barang datang dari supplier, input lewat Purchasing.
4. Jika ada koreksi stok, gunakan Stock Opname.
5. Saat pelanggan kredit membayar, buka Receivable lalu Add Payment.
6. Sore/malam, buka Report untuk rekap.
7. Jika ada produk baru, tambah Category lebih dulu jika kategorinya belum ada, lalu tambah Product.

## Alur Setup Awal Toko

Jika baru mulai dari database kosong:

1. Isi **General Setting > About**.
2. Isi **General Setting > App**.
3. Aktifkan fitur yang dibutuhkan di **General Setting > Feature**.
4. Buat **Category**.
5. Buat **Payment Method**.
6. Buat **Supplier**.
7. Buat **Product**.
8. Isi stok awal saat create product, atau input stok masuk lewat Purchasing.
9. Buat user dan role bila toko dipakai lebih dari satu orang.
10. Tes transaksi kecil dari POS.
11. Cek Selling History dan cetak struk.

## Praktik Aman

- Jangan sering mengubah stok langsung dari product setelah toko mulai berjalan.
- Gunakan Purchasing untuk barang masuk.
- Gunakan Stock Opname untuk koreksi hasil hitung fisik.
- Jangan approve purchasing/opname sebelum item detail benar.
- Pisahkan role kasir dan owner agar tombol approve dan setting tidak dipakai sembarangan.
- Backup database sebelum upload ke hosting atau sebelum perubahan besar.
