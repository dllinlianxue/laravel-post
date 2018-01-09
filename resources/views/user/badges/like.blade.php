@if(\Auth::id() != $target_user->id)
<div>
    @if(\Auth::user()->hasFan($target_user->id))
    <button class="btn btn-default like-button" like-value="1" like-user="{{$target_user->id}}" type="button" like-type="{{$type}}">取消关注</button>
    @else
    <button class="btn btn-default like-button" like-value="0" like-user="{{$target_user->id}}" type="button" like-type="{{$type}}">关注</button>
    @endif
</div>
@endif