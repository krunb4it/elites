
        </div> 

        <div id="uploadimageModal" class="modal" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <div id="image_demo"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success crop_image me-3">قص الصورة</button>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">الغاء</button>
                    </div>
                </div>
            </div>
        </div>
        
        <script src="<?=site_url()?>assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
        <script src="<?=site_url()?>assets/js/bootstrap.bundle.min.js"></script>
        <!-- 
        <script src="<?=site_url()?>assets/vendors/apexcharts/apexcharts.js"></script>
        <script src="<?=site_url()?>assets/js/pages/dashboard.js"></script>
         -->
	  
        <!-- Custom file -->
        <script src="<?=site_url()?>assets/vendors/toastify/toastify.js"></script>
        <script src="<?=site_url()?>assets/vendors/sweetalert2/sweetalert2.all.min.js"></script> 
		<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
	 
        <script src="<?=site_url()?>assets/js/jquery-sortable.js"></script> 
		 
        <script src="<?=site_url()?>assets/vendors/choices.js/choices.min.js"></script>
        <script src="<?=site_url()?>assets/vendors/ckeditor/ckeditor.js"></script>
        <script src="<?=site_url()?>assets/vendors/taginput/tagsinput.js"></script> 
		<script src="<?=site_url()?>assets/vendors/simple-datatables/simple-datatables.js"></script>
		
        <script src="<?=site_url()?>assets/js/main.js"></script> 
	 
		<script src="https://www.gstatic.com/firebasejs/7.23.0/firebase.js"></script> 
		<script>
			/*
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content');
				}
			});
		
		
			var firebaseConfig = {
				apiKey: "AIzaSyDq1VwYwa_zso4B4eN3KfKv1w9vB0EN9xY",
				authDomain: "elites-1c22d.firebaseapp.com",
				projectId: "elites-1c22d",
				storageBucket: "elites-1c22d.appspot.com",
				messagingSenderId: "1091862393481",
				appId: "1:1091862393481:web:2bce1e72e9855593fb4c58",
				measurementId: "G-YVQPTLB450"
			}; 
			
			firebase.initializeApp(firebaseConfig);
			const messaging = firebase.messaging();
		  
			function initFirebaseMessagingRegistration() {
				messaging
				.requestPermission()
				.then(function () {
					return messaging.getToken()
				})
				.then(function(token) {
					console.log(token);
					$.ajax({
						type: "post", 
						dataType: "html",
						url: "welcome/update_fcm_token",
						data: { fcm_token : token }
					});
				});
			}
			  
			messaging.onMessage(function(payload) {
				const noteTitle = payload.notification.title;
				const noteOptions = {
					body: payload.notification.body,
					icon: payload.notification.icon,
				};
				new Notification(noteTitle, noteOptions);
			});
			
			initFirebaseMessagingRegistration();
				*/
		</script>
    </body>
</html>


