<!DOCTYPE html>
<html>
	<head>
		<title>Добро пожаловать в Шмиксит!</title>
		<meta charset="UTF-8">
		<meta name="robots" content="noindex, nofollow"/>
		<link rel="stylesheet" href="/views/css/bootstrap.min.css" />
		<link rel="stylesheet" href="/views/css/index.css" />
	</head>
	<body>

		<nav class="navbar navbar-expand-md navbar-dark bg-dark">

			<div class="collapse navbar-collapse" id="navbarCollapse">
				<form class="form-inline ml-auto">
					{% if users is empty %}
						<button type="submit" class="btn btn-outline-light">Добавить игрока</button>
					{% else %}
						<select>
							<option id="0">Выберите игрока</option>
							{% for user in users %}
							<option id="{{ user.user_id }}">{{ user.name|e }}</option>
							{% endfor %}
						</select>
					{% endif %}
				</form>
			</div>
		</nav>

		<h1>Добро пожаловать {{ userName }}!</h1>
		<form action="/Shmixit/room" method="post">
			<input type="submit" name="create" value="Создать игру" />
			<input type="submit" name="join" value="Присоединиться к игре" />
			<input type="submit" name="show" value="Просмотр игры" />
		</form>

		{% if availableRooms is empty %}
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
				</tr>
				</thead>
				<tbody>
				{% for room in availableRooms %}
					<tr>
						<td>room.room_id</td>
						<td>room.name</td>
						<td>room.admin_user</td>
						<td>room.status</td>
					</tr>
				{% endfor %}
				</tbody>
			</table>
		{% endif %}

		<script src="/views/js/jquery-3.5.1.min.js"></script>
		<script src="/views/js/bootstrap.min.js"></script>
		<script src="/views/js/index.js"></script>
	</body>
</html>
