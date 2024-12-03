@extends('super-admin.superadmin')

@section('title', 'Message Inbox')
@section('header', 'Message Inbox')

@section('content')
<div class="bg-white shadow overflow-hidden sm:rounded-lg">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Received At</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($messages as $message)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">{{ $message->name }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $message->email }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $message->created_at->format('M d, Y H:i') }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($message->is_read)
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Read</span>
                    @else
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Unread</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <a href="{{ route('super-admin.view-message', $message->id) }}" class="text-blue-600 hover:text-blue-900 mr-2">View</a>
                    <form action="{{ route('super-admin.delete-message', $message->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $messages->links() }}
</div>
@endsection