<footer class="app-footer">
    <!-- To the end -->
    <div class="float-end d-none d-sm-inline">
        {{ cbLang('powered_by') }} {{Session::get('appname')}}
    </div>
    <!-- Default to the start -->
    <strong>{{ cbLang('copyright') }} &copy; <?php echo date('Y') ?>. {{ cbLang('all_rights_reserved') }} .</strong>
</footer>
