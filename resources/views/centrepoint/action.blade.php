<a href="{{ route('centre-point.edit',$model) }}" class="btn btn-warning btn-sm">Edit</a>
<button href="{{ route('centre-point.destroy',$model) }}" class="btn btn-danger btn-sm" id="delete">Hapus</button>

<script src="{{asset('assets/sweetalert2/dist/sweetalert2.all.min.js')}}"></script>

<script>
    $('button#delete').on('click',function(e){
        e.preventDefault();

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