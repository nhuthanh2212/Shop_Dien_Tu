@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Cập Nhật Danh Mục Sản Phẩm
            </header>

                <div class="panel-body">
                    <?php
                        $message = Session::get('message');
                        if($message){
                            echo '<span class="text-alert">'.$message.'</span>' ;
                            Session::put('message',null);
                        }
                    ?>
                    @foreach($edit as $key => $edit_value)
                    <div class="position-center">
                        <form role="form" action="{{URL::to('/update-category/'.$edit_value->category_id)}}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên Danh Mục</label>
                                    <input type="text" name="category_name" value="{{$edit_value->category_name}}" class="form-control" id="exampleInputEmail1">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Từ Khóa</label>
                                    <input type="text" name="category_keyword" value="{{$edit_value->category_keyword}}" class="form-control" id="exampleInputEmail1" placeholder="Từ Khóa.....">
                            </div>
                            <div class="form-group">
                                <label   for="exampleInputPassword1">Mô Tả Danh Mục</label>
                                <textarea style="resize: none;" rows="8" class="form-control" name="category_desc" id="exampleInputPassword1">{{$edit_value->category_desc}}
                                </textarea>
                            </div>
                            
                            
                            <button type="submit" name="add_category" class="btn btn-info">Cập Nhật Danh Mục</button>
                        </form>
                    </div>
                    @endforeach
                 </div>
        </section>

    </div>
@endsection