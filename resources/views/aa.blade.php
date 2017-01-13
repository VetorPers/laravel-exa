<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<div class="container">
    <div class="content">
        <div class="titles">
            <p>@{{ messages }}</p>
        </div>
    </div>
</div>
<script src="{{asset('js/vue.min.js')}}"></script>
<script>
    new Vue({
        el: '.titles',
        data: {
            messages: 'Hello Laravel!'
        }
    })
</script>
</body>
</html>