@extends('layouts.app')

@section ('content')
<main>
  <div class="container">
    @if ($message = Session::get('error'))
      <div class="alert alert-danger alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button> 
          <strong>{{ $message }}</strong>
      </div>
    @endif
    <div class="row" id="post-data">
      @include('data')
    </div>
    <div class="float-right">
      {{ $products->appends(['cari'=>request('cari')])->links() }}
    </div>
  </div>
</main>
@endsection

{{-- @section('js')
    <script type="text/javascript">
        let page = 1;
        $(window).scroll(function() {
            if($(window).scrollTop() + $(window).height() >= $(document).height()) {
                page++;
                loadMoreData(page);
            }
        });


        function loadMoreData(page){
          $.ajax(
                {
                    url: '?page=' + page,
                    type: "get",
                    beforeSend: function()
                    {
                        $('.ajax-load').show();
                    }
                })
                .done(function(data)
                {
                    if(data.html == ""){
                        $('.ajax-load').html("Sudah tidak ada produk lagi");
                        return;
                    }
                    $('.ajax-load').hide();
                    $("#post-data").append(data.html);
                })
                .fail(function(jqXHR, ajaxOptions, thrownError)
                {
                      alert('Server tidak merespon...');
                });
        }
    </script>
@endsection --}}