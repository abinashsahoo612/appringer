<html>
    <head>
        <title>Login Page</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-3 bg-primary mt-4" >
                    <h2>Login </h2>
                    @if ($errors->any())
                        <ul>
                            {!! implode('',$errors->all('<li>:message</li>')) !!}
                        </ul>
                    @endif
                    <form method="POST" action="/store">
                        <label for="">Name <input type="text" name="name"> </label><br>
                        <label for="">Email <input type="email" name="email"> </label><br>
                        <label for="">Password <input type="password" name="password"> </label><br>
                        <label for="">Confirm Password <input type="password" name="password_confirmation"> </label><br>
                        <input type="submit" value="Register">
                        @csrf
                    </form>
                </div>
            </div>


        </div>
    </body>
</html>
