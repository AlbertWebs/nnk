@extends('admin.layout')

@section('title', 'Email Details')
@section('page-title', 'Email Send Details')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <div class="p-6">
            <div class="mb-6">
                <a href="{{ route('admin.mailing-list.history') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Email History
                </a>
            </div>

            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Email Send Details</h2>

            <!-- Email Information -->
            <div class="bg-gray-50 rounded-lg p-6 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Subject</label>
                        <p class="text-lg text-gray-900 mt-1">{{ $emailSend->subject }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Group</label>
                        <p class="text-lg text-gray-900 mt-1">{{ $emailSend->group->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Sent By</label>
                        <p class="text-lg text-gray-900 mt-1">{{ $emailSend->sender->name ?? 'System' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Sent At</label>
                        <p class="text-lg text-gray-900 mt-1">
                            {{ $emailSend->sent_at ? $emailSend->sent_at->format('M d, Y H:i:s') : $emailSend->created_at->format('M d, Y H:i:s') }}
                        </p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Status</label>
                        <p class="mt-1">
                            @if($emailSend->status === 'completed')
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Completed
                                </span>
                            @elseif($emailSend->status === 'failed')
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Failed
                                </span>
                            @elseif($emailSend->status === 'sending')
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Sending
                                </span>
                            @else
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    Pending
                                </span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Statistics</label>
                        <p class="text-lg text-gray-900 mt-1">
                            <span class="text-green-600 font-medium">{{ $emailSend->sent_count }}</span>
                            <span class="text-gray-400 mx-1">/</span>
                            <span class="text-gray-600">{{ $emailSend->total_recipients }}</span>
                            @if($emailSend->failed_count > 0)
                                <span class="text-red-600 ml-2">({{ $emailSend->failed_count }} failed)</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="mt-4">
                    <label class="text-sm font-medium text-gray-500">Email Body</label>
                    <div class="mt-2 p-4 bg-white border border-gray-200 rounded-lg max-h-96 overflow-y-auto">
                        {!! $emailSend->body !!}
                    </div>
                </div>
            </div>

            <!-- Recipients List -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Recipients ({{ $emailSend->recipients->count() }})</h3>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Error</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sent At</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($emailSend->recipients as $index => $recipient)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $recipient->recipient_name ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $recipient->recipient_email }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($recipient->status === 'sent')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Sent
                                            </span>
                                        @elseif($recipient->status === 'failed')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Failed
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                Pending
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        @if($recipient->error_message)
                                            <div class="max-w-md truncate" title="{{ $recipient->error_message }}">
                                                {{ $recipient->error_message }}
                                            </div>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $recipient->sent_at ? $recipient->sent_at->format('M d, Y H:i:s') : '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

