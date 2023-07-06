<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header d-block text-center">
				<h4 class="modal-title d-inline-block">Confirm Delete</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body">
				<p class="text-center">Every informtation will be deleted.</p>
				<p class="text-center">Do you want to proceed?</p>
			</div>

			<div class="modal-footer justify-content-center">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<a class="btn btn-danger btn-ok" action="{{ $redirect??'' }}">Delete</a>
			</div>
		</div>
	</div>
</div>