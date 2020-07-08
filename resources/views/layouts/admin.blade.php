@include('admin.commons.header')
@include('admin.commons.left')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('admin.commons.breadcrumb')
    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            @include('admin/commons/alert')
            @yield('content')
        </div>
    </section>
    <!-- /.content -->
</div>
@include('admin.commons.footer')
<script>
    //roll bottom message-box
    var objDiv = document.getElementById("message-box");
    objDiv.scrollTop = objDiv.scrollHeight;
</script>
