<?php $this->load->view('admin/header') ?>

<h2><?=$title?></h2>

<div class="uu" style="background-color: #EEEEFF;border-radius: 6px;box-shadow: 0 1px 2px rgba(0,0,0,0.3);padding: 5px">

<?php if(validation_errors()){ ?>
    <div class="error alert alert-danger">
        <?= validation_errors() ?>
    </div>
<?php } ?>

<?php if($this->input->get('success') == 1){ ?>
    <div class="success alert alert-success">
        User sudah disimpan
    </div>
<?php } ?>

<?= form_open(current_url(),array('id'=>'validate')) ?>

<div class="col-md-4">

<h3>Username</h3>
<input <?php if($edit){ ?>readonly=""<?php } ?> value="<?=$edit?$result->UserName:set_value('UserName')?>" type="text" class="required form-control" name="UserName" />

<?php if($edit){ ?>
<br />
<div class="info alert alert-info">
    Password tidak usah diisi jika tidak diganti

<h3>Password</h3>
<input value="" type="password" class="form-control" name="Password" />
<h3>Ulangi Password</h3>
<input value="" type="password" class="form-control" name="RPassword" />
</div>
<?php }else{ ?>
<h3>Password</h3>
<input value="<?=set_value('Password')?>" type="password" class="required form-control" name="Password" />
<h3>Ulangi Password</h3>
<input value="<?=set_value('RPassword')?>" type="password" class="required form-control" name="RPassword" />
<?php } ?>

<h3>Role</h3>
<select name="RoleID" class="required form-control">
    <?php 
        $role = $this -> db -> order_by('RoleID', 'asc') -> get('roles');
        GetCombobox($role, "RoleID", "RoleName",$result->RoleID) 
    ?>
</select>
<br />
</div>
<!-- <div class="clearfix"></div> -->
<!-- <br /><br /> -->

<div class="col-md-8">
<fieldset>
    <legend><h3>User Information</h3></legend>
<table class="form table table-striped" border="0" width="100%">
    <tr>
        <td width="25%"><label for="FirstName">First Name</label></td>
        <td>
        <input id="FirstName" type="text" class="required form-control" name="FirstName" value="<?=$edit ? $result->FirstName : set_value('FirstName') ?>"  />
        </td>
    </tr>

    <tr>
        <td><label for="LastName">Last Name</label></td>
        <td>
        <input id="LastName" type="text" class="form-control" name="LastName" value="<?= $edit ? $result->LastName : set_value('LastName') ?>"  />
        </td>
    </tr>
    
    <tr>
        <td><label for="Gender">Jenis Kelamin</label></td>
        <td>
            <select id="Gender" class="required form-control" name="Gender">
                <option value="">-- Pilih --</option>
                <?php $g = $this -> db -> order_by('GenderID', 'asc') -> get('genders');
                    GetCombobox($g, 'GenderID', 'GenderName', $result->Gender);
                ?>
            </select>
        </td>
    </tr>

    <tr>
        <td><label for="BirthDate">Birth Date</label></td>
        <td>
        <input id="BirthDate" type="text" class="required form-control datepicker" name="BirthDate" value="<?= $edit ? $result->BirthDate : set_value('BirthDate') ?>"  />
        </td>
    </tr>

    <tr>
        <td><label for="StateName">Negara</label></td>
        <td>
            <select id="CountryID" class="required form-control" name="CountryID">
                <option value="">Pilih Negara</option>
                <?php $c = $this -> db -> order_by('CountryID', 'asc') -> get('countries');
                    GetCombobox($c, 'CountryID', 'CountryName', $edit ? $result->CountryID : set_value('CountryID'));
                ?>
            </select>
        </td>
    </tr>
    <tr>
        <td><label for="ProvinceName">Provinsi</label></td>
        <td>
            <select id="ProvinceID" class="required form-control" name="ProvinceID">
                <?php $p = $this -> db -> order_by('ProvinceID', 'asc') -> where('CountryID',$result->CountryID) -> get('provinces');
                    GetCombobox($p, 'ProvinceID', 'ProvinceName', $edit?$result->ProvinceID:'');
                ?>
            </select>
        </td>
    </tr>
    <tr>
        <td><label for="CityName">Kota</label></td>
        <td>
            <select id="CityID" class="required form-control" name="CityID">
                <?php $ct = $this -> db -> order_by('CityID', 'asc') -> where('ProvinceID',$result->ProvinceID) -> get('cities');
                    GetCombobox($ct, 'CityID', 'CityName', $edit?$result->CityID:'');
                ?>
            </select>
        </td>
    </tr>

    <tr>
        <td><label for="PassportNo">Passport No</label></td>
        <td>
        <input id="PassportNo" type="text" class="form-control" name="PassportNo" value="<?= $edit ? $result->PassportNo : set_value('PassportNo') ?>"  />
        </td>
    </tr>

    <tr>
        <td><label for="Email">Email</label></td>
        <td>
        <input id="Email" type="text" class="required email form-control" name="Email" value="<?= $edit ? $result->Email : set_value('Email') ?>"  />
        </td>
    </tr>
    
    <tr>
        <td><label for="Website">Website</label></td>
        <td>
        <input id="Website" type="text" class=" form-control" name="Website" value="<?= $edit ? $result->Website : set_value('Website') ?>"  />
        </td>
    </tr>

    <tr>
        <td><label for="Address">Address</label></td>
        <td><textarea class="required form-control" id="Address" name="Address"><?= $edit ? $result->Address : set_value('Address') ?></textarea></td>
    </tr>

    <tr>
        <td><label for="PhoneNumber">Phone Number</label></td>
        <td>
        <input id="PhoneNumber" type="text" class="form-control" name="PhoneNumber" value="<?=$edit ? $result->PhoneNumber : set_value('PhoneNumber') ?>"  />
        </td>
    </tr>

    <tr>
        <td><label for="ZipCode">Zip Code</label></td>
        <td>
        <input id="ZipCode" type="text" class=" form-control" name="ZipCode" value="<?=$edit ? $result->ZipCode : set_value('ZipCode') ?>"  />
        </td>
    </tr>
    <tr>
        <td><label for="Expired">Expired Date</label></td>
        <td>
        <input id="Expired" type="text" class="datepicker form-control" name="Expired" value="<?= $edit ? $result->Expired : set_value('Expired') ?>"  />
        </td>
    </tr>
    <tr>
        <td>
            <label>Profile Picture</label>
        </td>
        <td>
            <input style="width: 90%" type="file" name="userfile" id="userfile" class="ui btn btn-info" />
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; atau &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />
            <a href="<?=site_url('media/select')?>" class="pilihmedia btn btn-info"><b class="glyphicon glyphicon-picture"></b> Library</a>
            <?php $pp = $edit?$result->ProfilePicture:""; ?>
            <input type="hidden" id="MediaID" name="MediaID" value="<?=$pp?>" />
            <br /><br />
            <span class="uploadstatus"></span>
            <div class="success infomedia alert alert-success" style="<?php if(empty($pp)){ ?>display: none<?php } ?>">
                <?php
                    if(!empty($pp)){
                    $media = $this->db->where('MediaID',$pp)->get('media')->row();
                        ?>
                        <img src="<?=base_url()?>assets/images/media/<?=$media->MediaPath?>" width="100" /> <br />Gambar sudah dipilih <strong><?=$media->MediaName?></strong>.'
                        <?php
                    }
                ?>
                <a href="#" class="removemedia">x</a>
            </div>
        </td>
    </tr>
    
</table>
</fieldset>
</div>

<div class="clearfix"></div>

<div class="col-md-2">
    <h4>Is Verified ?</h4>
    <input type="checkbox" name="IsVerified" <?php if($edit){ if($result->IsVerified) echo 'checked=""'; } ?> id="Nona" value="1" /> <label for="Nona">Verified</label>
</div>

<div class="col-md-2">
    <h4>Non-aktif</h4>
    <input type="checkbox" name="IsSuspend" <?php if($edit){ if($result->IsSuspend) echo 'checked=""'; } ?> id="Non" value="1" /> <label for="Non">Non - aktif</label>    
</div>
<div class="clearfix"></div><br />

<p>
    <button class="ui btn btn-primary" type="submit"><b class="glyphicon glyphicon-save"></b> Simpan</button>
</p>

<script type="text/javascript">
    $(document).ready(function(){
       $('.error').addClass('alert alert-danger'); 
    });
</script>

<?= form_close(); ?>

</div>

<script type="text/javascript">
    
    $(document).ready(function(){
        
    
        $('.pilihmedia').click(function(){
            var a = this;
            $('#GeneralDialog').load($(a).attr('href'),{},function(){
                var dlg = this;
                $(dlg).dialog({
                    modal:true,
                    width:70+'%',
                    height:500,
                    show: 'clip',
                    title: 'Pilih Gambar'
                });
                $('.selectit',dlg).click(function(){
                    $('.removemedia').show();
                    $('#MediaID').val($(this).attr('mediaid'));
                    $('.infomedia').html('<img src="<?=base_url()?>assets/images/media/'+$(this).attr('src')+'" width="100" /> <br />Gambar sudah dipilih <strong>'+$(this).attr('title')+'</strong>. <a href="#" class="removemedia">x</a>').show();
                    $(dlg).dialog('close');
                    return false;
                });
            })
            return false;
        });
        
        $('#userfile').change(function(){
            $(this).attr('disable',true);
            $('.uploadstatus').html('Sedang mengupload file <img src="<?=base_url()?>assets/images/load.gif" alt="ajaxloading" />');
            $('form').ajaxSubmit({
                dataType: 'json',
                url: '<?=site_url('media/upload')?>',
                success : function(data){
                    $('.removemedia').show();
                    $('#MediaID').val(data.mediaid);
                    $('.infomedia').html('<img src="<?=base_url()?>assets/images/media/'+data.mediapath+'" width="100" /> <br />Gambar sudah dipilih <strong>'+data.mediapath+'</strong>.  <a href="#" class="removemedia">x</a>').show();
                    $(this).attr('disable',false);
                    $('.uploadstatus').empty();
                }
            });
        });
        
        $('.removemedia').live('click',function(){
            var kos = 0;
            var yakin = confirm('Apa anda yakin?');
            if(!yakin){
                return false;
            }
            $('#MediaID').val(kos);
            $(this).closest('.infomedia').empty().hide();
            return false;
        });
    $('#CountryID').change(function(){
                var con = this;
                $('#CityID').empty();
                $('#ProvinceID').unbind().load('<?=site_url('ajax/getprovinceoption')?>',{'id':$(con).val()},function(data){
                    $(this).change(function(){
                        var pro = this;
                        $('#CityID').unbind().load('<?=site_url('ajax/getcityoption')?>',{'province':$(pro).val()},function(data){
                            $('#CityID').change(function(){
                                $.ajax({
                                    url: '<?=site_url('ajax/cekshippingavailable')?>',
                                    data: {shipment:$('#ShipmentID').val(),city:$('#CityID').val()},
                                    dataType: 'json',
                                    type: 'post'
                                }).done(function(data){
                                    
                                });
                            });
                        });
                    });
                });
            });
            
    });
</script>

<?php $this->load->view('admin/footer') ?>