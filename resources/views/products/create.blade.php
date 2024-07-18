<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>upload files</title>
</head>
<body>
<div class="d-flex p-2">
<form action="{{route('products.store')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <label for="formGroupExampleInput" class="form-label">Project Name</label>
        <input type="text" class="form-control" id="formGroupExampleInput" placeholder="Example input placeholder" name="name">
        <div class="mt-4">
            <label for="formGroupExampleInput" class="form-label">Price</label>
            <input type="text" class="form-control" id="formGroupExampleInput" placeholder="Example input placeholder" name="price">
        </div>
        <div class="mt-4">
            <label for="formFile" class="form-label">Project File(ZIP)</label>
            <input class="form-control" type="file" id="formFile" name="file" accept=".zip">
        </div>
        <div class="mt-4">
            <label for="formFile" class="form-label">image</label>
            <input class="form-control" type="file" id="formFile" name="image" multiple="multiple">
        </div>

        <div class="mt-4">
            <label for="exampleFormControlTextarea1" class="form-label">Description</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description"></textarea>
        </div>

        <div class="mt-4">
        <label for="formFile" class="form-label">Seller</label>
        <select class="form-select" aria-label="Default select example" name="seller">
            @foreach($sellers as $seller)
            <option value="{{$seller['id']}}">{{$seller['name']}}</option>
            @endforeach
        </select>
        </div>
        <div class="mt-4">
            <label for="formFile" class="form-label">category</label>
            <select class="form-select" aria-label="Default select example" name="category">
                @foreach($categories as $category)
                <option value="{{$category['id']}}">{{$category['name']}}</option>
                @endforeach
            </select>
        </div>
        <div class="mt-4">
        <button type="submit" class="btn btn-success">SUBMIT</button>
        </div>
    </div>
</form>
</div>
</body>
</html>
