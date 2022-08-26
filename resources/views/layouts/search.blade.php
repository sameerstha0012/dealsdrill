<section class="search-banner small-banner">
    <div class="container">
        <div class="search-wrap">
            <h1>Search Now</h1>
            <h4>Buying and Selling Simplified.</h4>
            <form class="search-form" id="search-form" name="search" method="POST" action="{{ url('search') }}">
                @csrf
                <input type="search" name="keyword" placeholder="Keywords..."  value="{{ session('search') }}">
                <button id="search" type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </div>
</section>

<!-- <script>
    document.getElementById("search").addEventListener("click", function () {
        var form = document.getElementById("search-form");
        $.ajax({
            type: 'POST',
            url: form.action,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            dataType: 'json',
            data: $(form).serialize(), //Serialize a form to a query string.
            success:function(response) {
                if(response.success) {

                    $("#successreq").fadeIn(200).html(); 
                    var data = response.success;
                    if(data.length == 0) {
                        $("#reqoptions").html('<option value="0">None</option>');
                        $('#successreq').fadeOut().html();
                    }

                    $.each(data, function (i) {

                        var id = data[i].id;
                        var name = data[i].name;
                        if(i===0) {
                            $("#reqoptions").html('<option value="'+id+'">'+name+'</option>');
                        } else {
                            $("#reqoptions").append('<option value="'+id+'">'+name+'</option>');
                        }

                    });
                }

                if(response.error) {
                }

            }
        });
        return false; // prevent form to submit.
    });
</script> -->