@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thêm Vận Chuyển
            </header>

                <div class="panel-body">
                    <?php
                        $message = Session::get('message');
                        if($message){
                            echo '<span class="text-alert">'.$message.'</span>' ;
                            Session::put('message',null);
                        }
                    ?>
                    <div class="position-center">
                        <form>
                            @csrf
                                            
                            <div class="form-group">
                                <label for="exampleInputPassword1">Chọn Thành Phố</label>
                                <select name="city" id="city" class="form-control input-sm m-bot15 choose city">
                                    
                                    <option value="0">-----Chọn Tỉnh Thành Phố-----</option>
                                    @foreach($city as $key => $ci)
                                        <option value="{{$ci->matp}}">{{$ci->name_city}}</option>
                                    @endforeach
                                    
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Chọn Quận-Huyện</label>
                                <select name="province" id="province" class="form-control input-sm m-bot15 province choose">
                                    
                                    <option value="0">-----Chọn Quận Huyện------</option>
                                    
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Chọn Xã-Phường-Thị Trấn</label>
                                <select name="wards" id="wards" class="form-control input-sm m-bot15 wards">
                                    
                                    <option value="0">-----Chọn Xã Phường-----</option>
                                    
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Phí Vận Chuyển</label>
                                    <input type="text" name="fee_ship" class="form-control fee_ship" id="exampleInputEmail1" placeholder="Phí Vận Chuyển.....">
                            </div>
                            <button type="button" name="add_delivery" class=" btn btn-info add_delivery">THÊM PHÍ VẬN CHUYỂN</button>
                        </form>
                    </div>
                    <br>
                    <div id="load_delivery">
                        
                    </div>
                </div>
        </section>

    </div>
@endsection