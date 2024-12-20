
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet/less" type="text/css" href="./assets/css/login_style.less" />
    <title>Document</title>
</head>
<style>

</style>

<body>
    <div class="wrapper">
        <div class="container">
            <h1>ระบบการจัดเก็บเอกสารอิเล็กทรอนิกส์</h1>

            <form action="Authen\authen.php" method="post">
                <div class="form-group">
                    <input type="text" class="form-control" id="m_username" name="m_username" placeholder="Username"
                        minlength="2" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="exampleInputPassword1" name="password"
                        placeholder="Password" minlength="2" required>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>

        <ul class="bg-bubbles">
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            
        </ul>
    </div>
</body>
<script>
    $("#login-button").click(function (event) {
        event.preventDefault();

        $('form').fadeOut(500);
        $('.wrapper').addClass('form-success');
    });


</script>
<script src="https://cdn.jsdelivr.net/npm/less@4"></script>

</html>