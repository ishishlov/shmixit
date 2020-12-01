<div class="modal fade" id="pageErrorModal" tabindex="-1" role="dialog" aria-labelledby="pageErrorModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="pageErrorModalLabel">Скидыщ</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				{% set showError = error ? 1 : 0 %}
				<div id="page-error-text" class="form-group" data-show-error="{{ showError }}">
					<p>{{ error }}</p>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
			</div>
		</div>
	</div>
</div>