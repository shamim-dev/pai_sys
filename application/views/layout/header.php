<?php if($position=='Administrator'||$position=='Accounting'){?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Inventory System</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url('assets/bootstrap/css/bootstrap.css');?>" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo base_url('assets/bootstrap/css/logo-nav.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/font-awesome/css/font-awesome.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/swal/sweetalert.css');?>" rel="stylesheet">
    <script type="text/javascript">
        // To conform clear all data in cart.
        function clear_cart() {
        var result = confirm('Are you sure want to clear all bookings?');

        if (result) {
        window.location = "<?php echo base_url(); ?>billing/remove/all";
        } else {
        return false; // cancel button
        }
        }
    </script>

    

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">
                    <img src="http://placehold.it/150x50&text=Logo" alt="">
                </a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                             <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                Options<span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                 
                                  <li><a href="<?php echo base_url('account/inventory')?>"><i class="fa fa-simplybuilt"></i> Inventory</a></li>
                                  <li><a href="<?php echo base_url('account/orders')?>"><i class="fa fa-simplybuilt"></i> Orders</a></li>
                                
                                </ul>
                        </li>
                    <li>
                        <a href="<?php echo base_url('payroll')?>">Payroll</a>
                    </li>
                </ul> 
                <ul class=" nav navbar-right navbar-nav">
                    <li>
                      
                           <li class="dropdown">
                             <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                              <i class="fa fa-cog"></i>   My Profile<span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                   <li><a href="<?php echo base_url('account/edit/'. $eid);?>"><span class="glyphicon glyphicon-user"></span> User Profile</a></li>
                                     <?php if($position=='Administrator'){?>
                                  
                                  <li class="divider"></li>
                                  <li><a href="<?php echo base_url('account/view_employees');?>"><i class="fa fa-simplybuilt"></i> User Management</a></li>
                                    <?php }?>
                                   
                                   <li class="divider"></li>
                                   <li>  <a href="<?php echo base_url('logout')?>"><span class="glyphicon glyphicon-remove"></span> Logout</a></li>
                                </ul>
                        </li>
                     
                </li>
                    </ul>
                  
            </div>
            <!-- /.navbar-collapse -->      
        </div>
        <!-- /.container -->
    </nav>
    <?php }else{
    redirect(base_url(''));
}?>