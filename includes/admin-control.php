<?php 
	global $woocommerce;
$menus = get_registered_nav_menus();  
$menu = get_nav_menu_locations();
?>
<h1>Awesome Menu</h1>
<div class="wrap">
    <div class="row">
        <div class="col-md-12">
            <form action="#"  method="POST">
                <div class="form-group">
                    <label for="menu">Item Status</label>
                    <select class="form-control" name="menu" id="menu">
                    <option value="">Select a menu</option>
                    <?php foreach ($menus as $key => $value) {
                        echo '<option value="'.$key.'">'.$value.'</option>';
                    } ?>                    
                    </select>
                </div>
                <div class="form-group">
                    <label for="title_color">Product color</label><br>
                    <input type="text" class="colorpicker" name='title_color'  id="title_color" aria-describedby="help-nombre" required>
                    <small class="form-text text-muted">Change the color to product name</small>
                </div>
                <div class="form-group">
                    <label for="title_color_hover">Product hover color</label><br>
                    <input type="text" class="colorpicker" name='title_color_hover'  id="title_color_hover" aria-describedby="help-nombre" required>
                    <small class="form-text text-muted">Change color to hover product name</small>
                </div>
                <div class="form-group">
                    <label for="price_color">Price Color</label><br>
                    <input type="text" class="colorpicker" name='price_color'  id="price_color" aria-describedby="help-nombre" required>
                    <small class="form-text text-muted">Change color to product price</small>
                </div>
                <div class="form-group">
                    <label for="price_color_hover">Price Hover Color</label><br>
                    <input type="text" class="colorpicker" name='price_color_hover'  id="price_color_hover" aria-describedby="help-nombre" required>
                    <small class="form-text text-muted">Change Color to hover product price</small>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
</div>



<?php 
    if(isset($_POST["menu"])) {
        //echo $_POST["menu"];
        update_option( 'awesome_menu', $_POST["menu"], 'yes' );
    }