@if (session()->has('warning'))
    <script>toastr.warning(" {{ session('warning') }} ")</script>

@elseif(session()->has('success'))
    <script>toastr.success(" {{ session('success') }} ")</script>

@elseif(session()->has('info'))
    <script>toastr.info(" {{ session('info') }} ")</script>

@elseif(session()->has('error'))
    <script>toastr.error(" {{ session('error') }} ")</script>
@endif