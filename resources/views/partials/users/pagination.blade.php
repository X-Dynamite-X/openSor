@if(isset($paginator))
    {{ $paginator->links() }}
@elseif(isset($users))
    {{ $users->links() }}
@endif

