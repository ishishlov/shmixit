{% include('header.tpl') %}
{% include('select_user.tpl') %}

<div id="main-content">
	<h1>Добро пожаловать {{ currentUser.getName }}!</h1>

	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#roomModal">Создать новую игру</button>

	<div class="modal fade" id="roomModal" tabindex="-1" role="dialog" aria-labelledby="roomModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="roomModalLabel">Новая игра</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form>
						<div class="form-group">
							<label for="room-name" class="col-form-label">Если хочешь придумай название игры</label>
							<input type="text" class="form-control" id="room-name" maxlength="20">
							<div id="room-name-error"></div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
					<button id="saveRoom" type="button" class="btn btn-primary">Набор игроков</button>
				</div>
			</div>
		</div>
	</div>

	{% if rooms is empty %}
	<h3>Доступные игры</h3>
		<h3>Нет доступных игр. Походу надо создавать новую</h3>
	{% else %}
		<table class="table table-striped">
			<thead>
			<tr>
				<th>№</th>
				<th>Название</th>
				<th>Создатель</th>
				<th>Состояние</th>
				<th>Действие</th>
			</tr>
			</thead>
			<tbody>
			{% for room in rooms %}
				<tr>
					<td>{{ room.roomId }}</td>
					<td>{{ room.name }}</td>
					<td>{{ room.adminUser.name }}</td>
					<td>{{ room.statusName }}</td>
					<td>
						{% if room.status == 1 and not user.isGuest %}
							<button type="submit" class="btn btn-outline-dark">Войти</button>
						{% endif %}
						{% if room.status == 2 or room.status == 3 %}
							<button type="submit" class="btn btn-outline-dark">Просмотр</button>
						{% endif %}
					</td>
				</tr>
			{% endfor %}
			</tbody>
		</table>
	{% endif %}
</div>

{% include('footer.tpl') %}