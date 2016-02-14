<!DOCTYPE  html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <title><?php if(!empty($title)) echo $title," | " ?>Admin Page</title>
        <link href="<?=GetMediaPath(GetView('Ikon'))?>" rel="shortcut icon" type="image/png" />
        
        <script type="text/javascript" src="<?=base_url()?>assets/js/jquery-1.8.3.min.js"></script>
        <script type="text/javascript" src="<?=base_url()?>assets/js/jquery-ui-1.10.0.custom.min.js"></script>
        <script type="text/javascript" src="<?=base_url()?>assets/basic/js/bootstrap.min.js"></script>
        
        <!-- <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/basic/screen.css" /> -->
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/ui/jquery-ui-1.10.0.custom.css" />
        
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/basic/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/basic/css/bootstrap-theme.min.css" rel="stylesheet">
        
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/signin.css" />
        
        <script type="text/javascript">
            $(document).ready(function(){
               $('.ui').button(); 
            });
        </script>
    </head>
    <body>
        <!-- <div class="login"> -->
        <!-- <div class=" span-7 admin"> -->
        
        <?=form_open(current_url(),array('class'=>'form-signin'))?>
        
        <!-- <?php if(GetMediaPath(GetView('Logo'))){ ?>
            <p align="center"><img height="100" src="<?=GetMediaPath(GetView('Logo'))?>" /></p>
        <?php }?> -->
        <p align="center"><img height="100" src="<?=base_url().'assets/images/blaster.png'?>" /></p>
        
        <?php echo empty($error) ? "" : "<div class='error'>".$error."</div>"; ?>
        
        <label for="Username"><h4 style="margin: 5px 0 0">Username</h4></label>
        <input class="form-control" type="text" name="Username" id="Username" placeholder="Username" required autofocus />
        
        <label for="Password"><h4 style="margin: 5px 0 0">Password</h4></label>
        <input class="form-control" type="password" id="Password" name="Password" placeholder="Password" required/>
        
        <!-- <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label> -->
        
        <center>
        <button class="btn btn-primary" type="submit"><b class="glyphicon glyphicon-log-in"></b> Masuk</button>
        </center>
        
        <!-- <br />
        <p align="right">
            <button class="ui btnLogin" type="submit">Masuk</button>
        </p> -->
        <br />
        <?=anchor(base_url(),'<b style="margin-right: 5px;top:2px" class="glyphicon glyphicon-arrow-left"></b>Kembali ke Website')?>
        <?=form_close()?>
        
        
        
        <!-- </div> -->
        <!-- </div> -->
    </body>
</html>



