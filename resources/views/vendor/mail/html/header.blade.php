@props(['url'])

<tr>
    <td align="center">

        <table class="header-container" width="570" cellpadding="0" cellspacing="0" role="presentation" style="width:570px;">
            <tr>
                <td align="center"
                    style="background-color:#000000; padding:30px 20px;">

                    <a href="{{ $url }}" style="display:inline-block;">
                        <img src="{{ config('app.url') }}/assets/img/logo.png"
                             alt="{{ config('app.name') }}"
                             style="max-height: 64px; width:auto; display:block;">
                    </a>

                </td>
            </tr>
        </table>

    </td>
</tr>
