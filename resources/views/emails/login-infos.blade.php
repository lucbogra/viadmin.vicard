<h3>Hi, {{ $user->name }}</h3>
<p>Your credentials</p>
<table>
    <tr>
        <td>Email</td>
        <td style="margin-left: 10px;"><strong>{{ $user->email }}</strong></td>
    </tr>
    <tr>
        <td>Password</td>
        <td style="margin-left: 10px;"><strong>{{ $password }}</strong></td>
    </tr>
</table>
