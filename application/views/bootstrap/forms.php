<?php $this->load->view('partials/_header'); ?>

<style type="text/css">

</style>
<script>
    $(document).ready( function(){

    });
</script>
</head>
<body>
<div id="wrapper" class="active">
    <?php $this->load->view('partials/_sidebar.php'); ?>


	<div id="page-content-wrapper">
        <!-- http://bootsnipp.com/snippets/featured/navigation-sidebar-with-toggle -->
        <nav class="navbar navbar-default">
          <div class="container-fluid">
            <div class="navbar-header">
              <a class="navbar-brand" href="#">Navbar</a>
            </div>
            <div>
              <ul class="nav navbar-nav">
                <li class="active"><a href="#">Home</a></li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Page 1<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Sample 1</a></li>
                        <li><a href="#">Sample 2</a></li>
                        <li><a href="#">Sample 3</a></li>
                    </ul>
                </li>
                <li><a href="#">Page 2</a></li>
                <li><a href="#">Page 3</a></li>
              </ul>
            </div>
          </div>
        </nav>
    </div>

</div>
<?php $this->load->view('partials/_footer'); ?>