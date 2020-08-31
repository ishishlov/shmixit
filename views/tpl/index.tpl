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
					{% if user.isGuest %}
						<select>
							<option id="0">Выберите игрока</option>
							{% for user in users %}
							<option id="{{ user.user_id }}">{{ user.name|e }}</option>
							{% endfor %}
						</select>
					{% else %}
					<div class="">{{ user.getName }}</div>
						<button class="btn btn-outline-light">Выйти</button>
					{% endif %}
				</form>
			</div>
		</nav>

		<h1>Добро пожаловать {{ user.getName }}!</h1>
		<form action="/Shmixit/room" method="post">
			<input type="submit" name="create" value="Создать новую игру" />
		</form>

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

		<script src="/views/js/jquery-3.5.1.min.js"></script>
		<script src="/views/js/bootstrap.min.js"></script>
		<script src="/views/js/index.js"></script>
	</body>
</html>
