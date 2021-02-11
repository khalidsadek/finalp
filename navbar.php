<!doctype html>
<html lang="en">
<head>
    <title>Title</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="margin-bottom: 100px !important;">
    <div class="container">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNavDropdown" style="margin-left: 100px">
        <ul class="navbar-nav">
            <li class="nav-item <?php if($pageTitle == 'Main'){echo 'active';}?>">
                <a class="nav-link" href="/finalp/index.php">Main</a>
            </li>
            <li class="nav-item <?php if($pageTitle == 'nodes'){echo 'active';}?>">
                <a class="nav-link" href="/finalp/nodes.php">Nodes</a>
            </li>
            <li class="nav-item <?php if($pageTitle == 'pins'){echo 'active';}?>"">
                <a class="nav-link" href="/finalp/pins.php">Pins</a>
            </li>
        </ul>
    </div>
</div>
</nav>
<style>

li a:hover{
    color:yellow !important;
}
.active a{
    color:yellow !important;
    border-bottom: yellow 2px solid!important;
}
</style>
