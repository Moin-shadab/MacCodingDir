<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Create New Product</h1>
    <form action="{{route('product.store')}}" method="post">
        @csrf
        @method('post')
        <div>
            Name <input type="text" name="name">
        </div>
        <div>
            Quantity <input type="text" name="qty">
        </div>
        <div>
            Price <input type="text" name="price">
        </div>
        <div>
            Description <input type="text" name="description">
        </div>
        <div>
         <input type="submit" value="Save New Product">
        </div>
    </form>
</body>
</html>