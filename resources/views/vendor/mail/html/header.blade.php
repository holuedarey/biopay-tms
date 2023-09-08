@props(['url'])
<tr>
<td class="header" style="padding: 0">
<a href="{{ $url }}" style="display: inline-block;">
    @if (appLogo2()->image)
        <img src="{{ appLogo2()->value }}" class="logo" alt="Laravel Logo">
    @else
        @appName
    @endif
</a>
</td>
</tr>
