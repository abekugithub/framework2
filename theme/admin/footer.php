<div class="container">
    <footer><span>&copy; 2019 DashOne, All rights reserved.</span></footer>
</div>

<script src="theme/admin/assets/vendor/jquery/jquery.min.js"></script>
<script src="theme/admin/assets/vendor/bootstrap/bootstrap.min.js"></script>
<script src="media/js/sweet-alert.min.js"></script>
<script>
        $("#openbar").on('click', function () {
            $("#openbar").hide();
            $("#closebar").prop('hidden', false);
        });
        $("#closebar").on('click', function () {
            $("#openbar").show();
            $("#closebar").prop('hidden', true);
        });
    
        document.querySelector('a.logout').onclick = function(e){
        swal({
            title: "Warning?",
            text: "Are you sure you want to logout?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#5E72E4',
            confirmButtonText: "Yes, Logout!",
            closeOnConfirm: false
          },
          function(){
            window.location.href = 'index.php?action=logout';
        });    
    }
</script>
</body>
</html>