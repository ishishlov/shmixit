{% include('header.tpl') %}
{% include('select_user.tpl') %}

<h1>Новая игра</h1>

{% if users is empty %}
	<h3>Пока никто не присоединился к игре</h3>
{% else %}
	<table class="table table-striped">
		<thead>
		<tr>
			<th>№</th>
			<th>Игрок</th>
			<th>Действие</th>
		</tr>
		</thead>
		<tbody>
		{% for roomUser in users %}
		<tr>
			<td>{{ loop.index }}</td>
			<td>
				<img src="{{ roomUser.avatar }}">
				{{ roomUser.name }}
			</td>
			<td>
				{% if roomUser.getUserId() == currentUser.getUserId() %}
					<button type="submit" class="btn btn-outline-dark">Выйти</button>
				{% endif %}
			</td>
		</tr>
		{% endfor %}
		</tbody>
	</table>
{% endif %}

<a href="/">На главную</a>

{% include('footer.tpl') %}