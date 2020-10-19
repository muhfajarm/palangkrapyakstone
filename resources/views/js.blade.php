{{-- Loading Page --}}
<script>
    var myVar;

    function myFunction() {
        myVar = setTimeout(showPage, 500);
    }

    function showPage() {
        document.getElementById("loader").style.display = "none";
        document.getElementById("myDiv").style.display = "block";
    }
</script>
{{-- Loading Page --}}

{{-- Popover Cart --}}
<script>
    $(document).ready(function() {
        $('#popoverData').popover({
            html : true,
                container: 'body',
                content:function(){
                 return $('#popover_content_wrapper').html();
                }
        })
    })

    load_product();

    function load_product()
    {
        $.ajax({
        url:"/api/getPopover",
        method:"GET",
        success:function(data)
        {
            $('#cart_details').html(data.cart_data);
        }
        })
    }
</script>
{{-- Popover Cart --}}