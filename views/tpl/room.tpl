{% include('header.tpl') %}
{% include('select_user.tpl') %}

<h1>Новая игра</h1>

{% if users is empty %}
	<h3>Пока никто не присоединился к игре</h3>
{% else %}
	<table id="roomTable" class="table table-striped">
		<thead>
		<tr>
			<th>№</th>
			<th>Игрок</th>
			<th>Действие</th>
		</tr>
		</thead>
		<tbody class="user-table-body">
		{% for roomUser in users %}
		<tr id="user-table-row-{{ roomUser.id }}">
			<td id="index-user-id-{{ roomUser.id }}">{{ loop.index }}</td>
			<td>
				<img src="{{ roomUser.avatar }}">
				{{ roomUser.name }}
			</td>
			<td>
				{% if roomUser.id == currentUser.getUserId() %}
					<button id="leaveRoom" type="submit" class="btn btn-outline-dark" data-user-id="{{ roomUser.id }}">Выйти</button>
				{% endif %}
			</td>
		</tr>
		{% endfor %}
		</tbody>
	</table>
{% endif %}

<a href="/">На главную</a>

<button id="startGame" disabled type="submit" class="btn btn-success btn-lg btn-block">Старт игры</button>

<div id="roomData"
	 data-room-id="{{ room_id }}"
	 data-user-ids-list="{{ user_ids_list }}"
 >
 </div>
{% include('footer.tpl') %}