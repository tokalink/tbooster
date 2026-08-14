<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3.7.1 -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<!-- Bootstrap 5.3.3 Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

<!-- OverlayScrollbars -->
<script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js" crossorigin="anonymous"></script>

<!-- Select2 JS -->
<script src="{{ asset('vendor/crudbooster/assets/select2/dist/js/select2.full.min.js') }}"></script>

<!-- AdminLTE 4 App -->
<script src="{{ asset('vendor/crudbooster/assets/adminlte4/js/adminlte.min.js') }}"></script>

<!--SWEET ALERT-->
<script src="{{asset('vendor/crudbooster/assets/sweetalert/dist/sweetalert.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('vendor/crudbooster/assets/sweetalert/dist/sweetalert.css')}}">

<!--MONEY FORMAT-->
<script src="{{asset('vendor/crudbooster/jquery.price_format.2.0.min.js')}}"></script>

<!--DATATABLE (Bootstrap 5)-->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<script>
    var ASSET_URL = "{{asset('/')}}";
    var APP_NAME = "{{Session::get('appname')}}";
    var ADMIN_PATH = '{{url(config("crudbooster.ADMIN_PATH")) }}';
    var NOTIFICATION_JSON = "{{route('NotificationsControllerGetLatestJson')}}";
    var NOTIFICATION_INDEX = "{{route('NotificationsControllerGetIndex')}}";

    var NOTIFICATION_YOU_HAVE = "{{cbLang('notification_you_have')}}";
    var NOTIFICATION_NOTIFICATIONS = "{{cbLang('notification_notification')}}";
    var NOTIFICATION_NEW = "{{cbLang('notification_new')}}";

    $(function () {
        $('.datatables-simple').DataTable();
    })
</script>
<script src="{{asset('vendor/crudbooster/assets/js/main.js').'?r='.time()}}"></script>
