<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            th{
                margin :0 20px 0 20px;
                padding:0 20px 0 20px;
            }
            b{
                font-size: x-large;
                color:darkblue;
            }

            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            .selector-for-some-widget {
                box-sizing: content-box;
            }
        </style>

        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css"/>

        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    </head>
    <body>

        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <br>
                <input name="user" id="user">
                <input name="pass" id="pass">
                <button id="login" class="btn btn-success">login</button>

                <br>
                <button id="load" class="btn btn-success">load tracks</button>
                <br>


                <div class="box-body scrollit">
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th><b>#</b></th>
                            <th><b>Name </b></th>
                            <th><b>Length</b></th>
                             <th><b>Artist</b></th>
                            <th><b>Music</b></th>

                            <th><b>Download</b></th>
                        </tr>
                        </thead>
                        <tbody id="myTable">

                        {{--@foreach($tracks as $d)--}}
                            {{--<tr>
                                <th>{{$d->id}}</th>
                                <th>{{$d->name}}</th>
                                <th>{{$d->length}}</th>
                                <th>{{$d->artist}}</th>
                                <th>
                                    <audio controls name="{{$d->name}}">
                                        <source src="{{$d->url}}" type="audio/mpeg">
                                    </audio>
                                </th>



                                <th><a href="{{URL::to('word/delete/'.$d->id)}}" class="btn btn-danger" id="deletes">Download</a></th>

                            </tr>--}}
                        {{--@endforeach--}}

                        </tbody>

                    </table>
                </div>

                <div class="container">

                </div>


                <div class="<!--title--> <!--m-b-md-->">
                    Laravel
                </div>

                {{--<div class="links">
                    <a href="https://laravel.com/docs">Docs</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://blog.laravel.com">Blog</a>
                    <a href="https://nova.laravel.com">Nova</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div>--}}
            </div>
        </div>


    </body>



<script>
    $(document).ready(function(){
        //start login
        $('#login').on('click',function(){
            var user=$('#user').val();
            var pass=$('#pass').val();
            $.ajax({
                type:"post",
                url: "{{route('logi-user')}}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data:{user:user,pass:pass,"_token": "{{ csrf_token() }}",},
                success:function(res){
                    console.log(res);
                    if(res === 'successful'){
                        alert('logged in success')
                    }else{
                        alert('logged in failed')
                    }

                }
            });
        });


        //end login


        //start loading tracks
        $('#load').on('click',function(){
            $.ajax({
                type:"get",
                url:"{{url('/load-tracks')}}",
                success:function(result){
                    if(result){
                        $('#myTable').empty();
                        loadData(result);
                        console.log(result);
                    }else{

                        console.log("Error");
                    }
                }
            });
        });
        //end loading tracks
    });

    //start downloading a track
    /*$(document).on('click','.audio',function (e) {
        var user ="{{Session::get('user')}}";
        if(user != 'success'){
            e.preventDefault();
            $("#myModal").modal()
        }else{
            var urll = $(this).attr('href');
            console.log(urll);
            $.ajax({
                type:"get",
                url:"{{url('/download-track?urll=')}}"+urll,
                success:function(result){
                    console.log(result);
                    if(result){
                        console.log('audio downloading success');
                    }else{
                        console.log('audio downloading failed');
                    }
                }
            });
        }


    });*/
    //end downloading a track


    function loadData(data){
        $.each(data, function (key, value) {
            var audio = "{{asset('/download-track?urll=')}}"+value.url;

            var tracks = '<tr>\n' +
                '                                <th>'+ parseInt(key+1) +'</th>\n' +
                '                                <th>'+value.name+'</th>\n' +
                '                                <th>'+value.length+'</th>\n' +
                '                                <th>'+value.artist+'</th>\n' +
                '                                <th>\n' +
                '                                    <audio controls name="'+value.name+'">\n' +
                '                                        <source src="'+value.url+'" type="audio/mpeg">\n' +
                '                                    </audio>\n' +
                '                                </th>\n' +
                '                                \n' +
                '                                <th><a target="_blank " href="'+audio+'" class="btn btn-danger audio">Download</a></th>\n' +
                '\n' +
                '                            </tr>';
            $('#myTable').append(tracks);
        });
    }
</script>



    {{--<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>--}}
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</html>
