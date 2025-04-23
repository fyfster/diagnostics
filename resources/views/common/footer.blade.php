            <!-- Copyright -->
            @include('common/copyright')
            <!-- End of Copyright -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
    <script>
        var TOKEN = "{{ csrf_token() }}";
        var DATATABLES_LOCALE_URL = "{{ asset('datatables/lang/' . app()->getLocale() . '.json') }}";
        var BASE_URL = {
            notifications: "{{ route('notifications') }}",
            notifications_read: "{{ route('notifications-read') }}"
        };
    </script>
    <script src="{{ asset('js/notification.js') }}"></script>
</body>

</html>