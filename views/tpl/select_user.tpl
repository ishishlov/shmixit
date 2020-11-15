<nav class="navbar navbar-expand-md navbar-dark bg-dark user-navbar">

	{% if currentUser.isGuest %}
	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#userModal">Новый игрок</button>

	<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="userModalLabel">Новый игрок</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form>
						<div class="form-group">
							<label for="user-name" class="col-form-label">Ник, имя, кликуха, погоняло:</label>
							<input type="text" class="form-control" id="user-name" maxlength="20">
							<div id="user-name-error"></div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
					<button id="saveUser" type="button" class="btn btn-primary">Сохранить</button>
				</div>
			</div>
		</div>
	</div>
	{% endif %}

	<div class="collapse navbar-collapse" id="navbarCollapse">
		<form class="form-inline ml-auto">
			{% if currentUser.isGuest %}
				<select id="login">
					<option value="0">Выберите игрока</option>
					{% for user in users %}
						<option value="{{ user.getUserId }}">{{ user.getName()|e }}</option>
					{% endfor %}
				</select>
			{% else %}
				<button id="logout" class="btn btn-outline-light">Выйти</button>
			{% endif %}
		</form>
	</div>
</nav>