<?php
$id = $_SESSION['user_id'];
/*$all_modules = $this->db->get('modules')->result_array();
$module_permission = array();
foreach ($all_modules as $moduledata) {
  $module_permission[] = $moduledata['module_slug'];
}

$module = 'users';
$query = $this->db->get_where($module, array('id' => $id));
$user = $query->result_array();
if($id != 1){
    //$permission = $this->permission->grant('users','edit');
    $user_permission = json_decode($user[0]['module_permission'],true);
    if($user_permission){
      foreach ($user_permission as $user_perm) {
        # code...
      }
    }
}
//echo '<pre>';print_r($module_permission);exit;
*/
?>
<?php $menu_class = $this->router->fetch_class(); ?>
<?php $slug_name = $this->uri->segment(2); ?>
<nav class="mt-2">
  <!-- <ul class="nav nav-pills nav-sidebar flex-column text-sm nav-flat nav-compact nav-child-indent" data-widget="treeview" role="menu" data-accordion="false"> -->
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <li class="nav-item">
      <a href="<?php echo base_url().'admin/dashboard';?>" class="nav-link <?php if($menu_class == 'dashboard'){ echo 'active';}?>">
        <i class="nav-icon fa fa-tachometer-alt text-sm"></i>
        <p>
          Dashboard
        </p>
      </a>
    </li>
    <!-- Add icons to the links using the .nav-icon class
         with font-awesome or any other icon font library -->
    <?php 
        $modules = $this->db->where('parent',0)->get('modules')->result_array();
        foreach ($modules as $value){
          $permission = $this->permission->grant($value['module_slug'],'view');

          if($id == 1 || $permission == true){

          if($value['has_child'] == 1){

            $sub_modules = $this->db->where('parent',$value['id'])->get('modules')->result_array();
            $module_slug = array_column($sub_modules, 'module_slug');
            $menu_class = str_replace('_', '-', $menu_class);
    ?>
    <li class="nav-item has-treeview <?php if($module_slug){ if(in_array($menu_class,$module_slug) || in_array($slug_name,$module_slug)){ echo 'menu-open';} } ?>">
      <a href="#" class="nav-link <?php if($module_slug){ if(in_array($menu_class,$module_slug) || in_array($slug_name,$module_slug)){ echo 'active';} } ?>">
        <i class="nav-icon <?php echo $value['icon'];?> text-sm"></i>
        <p>
          <?php echo $value['module_name'];?>
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>
      <?php if($sub_modules){ ?>
      <ul class="nav nav-treeview">
        <?php 
        foreach ($sub_modules as $value2) { 
          $sub_permission = $this->permission->grant($value2['module_slug'],'view');
          if($id == 1 || $sub_permission == true){
        ?>
        <li class="nav-item">
          <a href="<?php echo base_url().'admin/'.$value2['module_slug'];?>" class="nav-link <?php if($menu_class == $value2['module_slug'] || $slug_name == $value2['module_slug']){ echo 'active'; } ?>">
            <i class="<?php echo $value2['icon'];?> nav-icon text-sm"></i>
            <p><?php echo $value2['module_name'];?></p>
          </a>
        </li>
        <?php } } ?>
      </ul>
      <?php } ?>
    </li>
    <?php }else{ //echo $menu_class;//if($id == 1 || $permission){ ?>
    <li class="nav-item">
      <a href="<?php echo base_url().'admin/'.$value['module_slug'];?>" class="nav-link <?php if($menu_class == $value['module_slug']){ echo 'active';}?>">
        <i class="nav-icon <?php echo $value['icon'];?> text-sm"></i>
        <p>
          <?php echo $value['module_name'];?>
        </p>
      </a>
    </li>
    <?php } } } ?>
  </ul>
</nav>