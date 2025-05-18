<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Hellow World!</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Description</th>
            <th>Edit</th>
        </tr>
        
            @foreach($product as $prod)
                <tr>
                <td>{{$prod->id}}</td>
                <td>{{$prod->name}}</td>
                <td>{{$prod->qty}}</td>
                <td>{{$prod->price}}</td>
                <td>{{$prod->description}}</td>
                <a href="{{route('product.edit', [product=>$prod])}}">Edit</a>
            </tr>
            @endforeach
        
    </table>
</body>
</html>