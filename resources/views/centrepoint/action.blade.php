{{-- pada view action terdapat 2 button edit data dan hapus data --}}
<a href="{{ route('centre-point.edit',$model) }}" class="btn btn-warning btn-sm">Edit</a>
<button href="{{ route('centre-point.destroy',$model) }}" class="btn btn-danger btn-sm" id="delete">Hapus</button>

{{-- pada view action kita meload cdn sweetalert 2 untuk menampilkan alert dialog dari sweet alert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // ketika button dengan id delete di klik akan menjalankan fungsi dari sweetalert2 
    $('button#delete').on('click',function(e){
        // mencegah button untuk memuat halaman saat tombol di klik
        e.preventDefault();

    // Menampilkan alert dialg dari sweetalert 2
        var href = $(this).attr('href');

            Swal.fire({
            title: 'Hapus Data Ini?',
            text: "Perhatian data yang sudah di hapus tidak bisa di kembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText : 'Batal!'
            }).then((result) => {
            if (result.isConfirmed) {

                // jika tombol Ya hapus di klik selanjutnya akan mencari element dengan id deleteform
                // lalu mengubah opsi action yang ada dengan var href yang di definisikan di atas dimana attribut href
                // tersebut ada pada button delete yang mengarah ke route destroy pada controller centrepoint
                document.getElementById('deleteForm').action = href;
                document.getElementById('deleteForm').submit();

                Swal.fire(
                'Terhapus!',
                'Data sudah terhapus.',
                'success'
                )
            }
            })
        });

</script>