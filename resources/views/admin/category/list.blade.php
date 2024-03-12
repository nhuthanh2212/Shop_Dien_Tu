@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Liệt Kê Danh Mục
    </div>
    <div class="row w3-res-tb">
      <div class="col-sm-5 m-b-xs">
        <select class="input-sm form-control w-sm inline v-middle">
          <option value="0">Bulk action</option>
          <option value="1">Delete selected</option>
          <option value="2">Bulk edit</option>
          <option value="3">Export</option>
        </select>
        <button class="btn btn-sm btn-default">Apply</button>                
      </div>
      <div class="col-sm-4">
      </div>
      <div class="col-sm-3">
        <div class="input-group">
          <input type="text" class="input-sm form-control" placeholder="Search">
          <span class="input-group-btn">
            <button class="btn btn-sm btn-default" type="button">Go!</button>
          </span>
        </div>
      </div>
    </div>
    <div class="table-responsive">
        <?php
            $message = Session::get('message');
                if($message){
                    echo '<span class="text-alert">'.$message.'</span>' ;
                        Session::put('message',null);
                }
                    ?>
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th style="width:20px;">
              <label class="i-checks m-b-none">
                <input type="checkbox"><i></i>
              </label>
            </th>
            <th>Tên Danh Mục</th>
            <th>Mô Tả Danh Mục</th>
            <th>Trạng Thái</th>
           
            <th>Quản Lý</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
            @foreach($list as $key => $cate )
          <tr>
            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
            <td>{{$cate->category_name}}</td>
            <td><span class="text-ellipsis">{{$cate->category_desc}}</span></td>
           
            <td><span class="text-ellipsis">
                <?php 
                if($cate->category_status==0){
                    ?>
                    <a href="{{URL::to('/unactive-category/'.$cate->category_id)}}"><span class="fa-thumb-styling fa fa-thumbs-down"></span></a>
                <?php 
                }
                else{
                ?>
                    <a href="{{URL::to('/active-category/'.$cate->category_id)}}"><span class="fa-thumb-styling fa fa-thumbs-up"></span></a>
                    <?php
                }
                
                ?>
                

            </span></td>
            <td>
                <a href="{{URL::to('edit-category/'.$cate->category_id)}}" class="active styling-edit" ui-toggle-class="">
                    <i class="fa fa-pencil-square text-success text-active"></i>
                </a>
                 <a onclick="return confirm('Bạn Có Muốn Xóa Danh Mục Này Không?')" href="{{URL::to('delete-category/'.$cate->category_id)}}" class=" active styling-edit">
                    <i class="fa fa-times text-danger text"></i>
                </a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <!-- import data -->
      <form action="{{url('/import-csv')}}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" accept=".xlsx"><br>
        <input type="submit" name="import_csv" value="Import Excel" class="btn btn-warning">
        
      </form>

      <!-----export------>
      <form action="{{url('/export-csv')}}" method="post">
        @csrf
        
        <input type="submit" name="export_csv" value="Export Excel" class="btn btn-success">
        
      </form>
    </div>
    <!-- <footer class="panel-footer">
      <div class="row">
        
        <div class="col-sm-5 text-center">
          <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
        </div>
        <div class="col-sm-7 text-right text-center-xs">                
          <ul class="pagination pagination-sm m-t-none m-b-none">
            <li><a href=""><i class="fa fa-chevron-left"></i></a></li>
            <li><a href="">1</a></li>
            <li><a href="">2</a></li>
            <li><a href="">3</a></li>
            <li><a href="">4</a></li>
            <li><a href=""><i class="fa fa-chevron-right"></i></a></li>
          </ul>
        </div>
      </div>
    </footer> -->
  </div>
</div>
    
@endsection