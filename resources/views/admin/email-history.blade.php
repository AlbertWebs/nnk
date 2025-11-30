@extends('admin.layout')

@section('title', 'Email History')
@section('page-title', 'Email Send History')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <div class="p-6">
            <div class="mb-6">
                <a href="{{ route('admin.mailing-list') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Mailing List
                </a>
            </div>

            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Email Send History</h2>

            @if($emailSends->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Group</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sent By</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Recipients</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($emailSends as $emailSend)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $emailSend->sent_at ? $emailSend->sent_at->format('M d, Y H:i') : $emailSend->created_at->format('M d, Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        <div class="max-w-xs truncate" title="{{ $emailSend->subject }}">
                                            {{ $emailSend->subject }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $emailSend->group->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $emailSend->sender->name ?? 'System' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div class="flex items-center space-x-2">
                                            <span class="text-green-600 font-medium">{{ $emailSend->sent_count }}</span>
                                            <span class="text-gray-400">/</span>
                                            <span class="text-gray-600">{{ $emailSend->total_recipients }}</span>
                                            @if($emailSend->failed_count > 0)
                                                <span class="text-red-600">({{ $emailSend->failed_count }} failed)</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($emailSend->status === 'completed')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Completed
                                            </span>
                                        @elseif($emailSend->status === 'failed')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Failed
                                            </span>
                                        @elseif($emailSend->status === 'sending')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Sending
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                Pending
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.mailing-list.history.detail', $emailSend->id) }}" class="text-blue-600 hover:text-blue-900">
                                            View Details
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $emailSends->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No email history</h3>
                    <p class="mt-1 text-sm text-gray-500">No emails have been sent yet.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

