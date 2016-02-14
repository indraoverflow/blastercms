<?php $this -> load -> view('header') ?>
<section>
    <div class="user_register">
        <h3><?php echo $title ?></h3>
        
        <?php if(validation_errors()){ ?>
            <div class="error">
                <?= validation_errors() ?>
            </div>
        <?php } ?>
        
        <?=form_open(site_url('user/register'),array('id'=>'validate'))?>
        
        <table>
            
            <tr>
                <td width="200px"><label for="FirstName"><h4>Nama Depan</h4></label></td>
                <td> : <input class="required" style="width: 300px" type="text" id="FirstName" name="FirstName" value="<?=set_value('FirstName')?>" /></td>
            </tr>
            <tr>
                <td><label for="LastName"><h4>Nama Belakang</h4></label></td>
                <td> : <input style="width: 300px" type="text" id="LastName" name="LastName" value="<?=set_value('LastName')?>" /></td>
            </tr>
            <tr>
                <td><label for="Email"><h4>Email</h4></label></td>
                <td> : <input class="required email" style="width: 300px" type="text" id="Email" name="Email" value="<?=set_value('Email')?>" /></td>
            </tr>
            <tr>
                <td><label for="UserName"><h4>Username</h4></label></td>
                <td> : <input class="required" style="width: 300px" type="text" id="UserName" name="UserName" value="<?=set_value('UserName')?>" /></td>
            </tr>
            <tr>
                <td><label for="Password"><h4>Password</h4></label></td>
                <td> : <input class="required" style="width: 300px" type="password" id="Password" name="Password" value="<?=set_value('Password') ?>" /></td>
            </tr>
            <tr>
                <td><label for="RPassword"><h4>Confirm Password</h4></label></td>
                <td> : <input class="required" style="width: 300px" type="password" id="RPassword" name="RPassword" value="<?=set_value('RPassword') ?>" /></td>
            </tr>
            <tr>
                <td><label for="Gender">Jenis Kelamin</label></td>
                <td>: 
                    <select id="Gender" class="required" name="Gender">
                        <option value="">-- Pilih --</option>
                        <?php $g = $this -> db -> order_by('GenderID', 'asc') -> get('genders');
                            GetCombobox($g, 'GenderID', 'GenderName', set_value('Gender'));
                        ?>
                    </select>
                </td>
            </tr>
            
            <tr>
                <td><label for="StateName">Negara</label></td>
                <td>: 
                    <select id="CountryID" class="required" name="CountryID">
                        <option value="">Pilih Negara</option>
                        <?php $c = $this -> db -> order_by('CountryID', 'asc') -> get('countries');
                            GetCombobox($c, 'CountryID', 'CountryName', set_value('CountryID'));
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label for="ProvinceName">Provinsi</label></td>
                <td>: 
                    <select id="ProvinceID" class="required" name="ProvinceID">
                        <?php $p = $this -> db -> order_by('ProvinceID', 'asc') -> where('CountryID',set_value('CountryID')) -> get('provinces');
                            GetCombobox($p, 'ProvinceID', 'ProvinceName', set_value('ProvinceID'));
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label for="CityName">Kota</label></td>
                <td>: 
                    <select id="CityID" class="required" name="CityID">
                        <?php $ct = $this -> db -> order_by('CityID', 'asc') -> where('ProvinceID',set_value('ProvinceID')) -> get('cities');
                            GetCombobox($ct, 'CityID', 'CityName', set_value('CityID'));
                        ?>
                    </select>
                </td>
            </tr>
            
            <!-- <tr>
                <td><label for="Address">Address</label></td>
                <td>: 
                    <input class="required" style="width: 300px" type="text" id="Address" name="Address" value="<?=set_value('Address')?>" />
                </td>
            </tr> -->
            
            <tr>
                <!-- <td>&nbsp;</td> -->
                <td colspan="2">
                    <center><input type="submit" class="ui" value="Daftar" /></center>
                </td>
            </tr>
        </table>
        
        
        <?form_close()?>
    </div>
</section>
<script type="text/javascript">
    $(document).ready(function(){
       $('#validate').validate();
       $('#CountryID').change(function(){
                var con = this;
                $('#CityID').empty();
                $('#ProvinceID').unbind().load('<?=site_url('ajax/getprovinceoption')?>',{'id':$(con).val()},function(data){
                    $(this).change(function(){
                        var pro = this;
                        $('#CityID').unbind().load('<?=site_url('ajax/getcityoption')?>',{'province':$(pro).val()},function(data){
                            $('#CityID').change(function(){
                                $.ajax({
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
<?php $this -> load -> view('footer') ?>
