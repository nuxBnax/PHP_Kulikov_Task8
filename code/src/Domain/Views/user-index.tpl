<p>{{ title }}</p>
<a class="link__btn-create" href="/user/edit/">Добавить Юзера</a>
<ul id="navigation">
    {% for user in users %}
        <li class='user__item'>
        <h4>{{ user.getUserName() }} {{ user.getUserLastName() }}. День рождения: {{ user.getUserBirthday() | date('d.m.Y') }}</h4>
        <a class="link__btn-delete" href="/user/delete/?id={{user.getUserId()}}">Удалить - {{ user.getUserName()}}</a>
        <a class="link__btn-update" href="/user/change/?id={{user.getUserId()}}">Изменить</a> 
        </li>
    {% endfor %}
</ul>