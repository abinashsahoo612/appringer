<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Laravel Pagination Demo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
    <a href="logout" class="btn btn-danger mb-2" style="float:right">Log Out</a>
        <table class="table table-bordered mb-5">
            <thead>
                <tr class="table-success">
                    <th scope="col">#</th>
                    <th scope="col">Authors</th>
                    <th scope="col">Title</th>
                    <th scope="col">Subtitle</th>
                    <th scope="col">Thumbnail</th>
                    <th scope="col">Small Thumbnail</th>
                </tr>
            </thead>
            <tbody>
                @foreach($books as $key => $data)
                <tr>
                    <th scope="row">{{ $key+1 }}</th>
                    <td>{{ $data->authors }}</td>
                    <td>{{ $data->title }}</td>
                    <td>{{ $data->subtitle }}</td>
                    <td>{{ $data->thumbnail }}</td>
                    <td>{{ $data->small_thumbnail }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
    </div>
</body>
</html>