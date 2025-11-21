@extends('admin.layout')

@section('title', 'Send Email')
@section('page-title', 'Send Email to Group')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="mb-6">
            <a href="{{ route('admin.mailing-list') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Mailing List
            </a>
        </div>

        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Send Email to Group</h2>
        
        <form id="send-email-form" onsubmit="sendEmail(event)">
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Select Group</label>
                <select id="email-group-select" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Choose a group...</option>
                </select>
                <p id="group-info" class="mt-2 text-sm text-gray-500"></p>
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Email Subject</label>
                <input type="text" id="email-subject" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter email subject">
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Message Body</label>
                <div id="email-body" style="min-height: 300px;"></div>
                <input type="hidden" id="email-body-hidden" required>
                <p class="mt-2 text-sm text-gray-500">Use the toolbar above to format your email. The email will be styled with an email-friendly theme.</p>
            </div>
            
            <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-yellow-600 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-yellow-800">Important</p>
                        <p class="text-sm text-yellow-700 mt-1">This email will be sent to all members of the selected group. Please review your message before sending.</p>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.mailing-list') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Cancel</a>
                <button type="submit" class="px-6 py-2 bg-purple-500 hover:bg-purple-600 text-white rounded-lg">
                    Send Email
                </button>
            </div>
        </form>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.snow.css">
<style>
    .ql-container {
        min-height: 300px;
        font-size: 16px;
    }
    .ql-editor {
        min-height: 300px;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.js"></script>
<script>
const API_BASE = '/api/mailing-list';
let quillEditor;

// Initialize Quill editor
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Quill
    quillEditor = new Quill('#email-body', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'align': [] }],
                ['link', 'image'],
                ['blockquote', 'code-block'],
                ['clean']
            ]
        },
        placeholder: 'Compose your email message here...'
    });
    
    loadGroups();
    
    // Update group info when selection changes
    document.getElementById('email-group-select').addEventListener('change', function() {
        updateGroupInfo();
    });
});

// Load Groups
async function loadGroups() {
    try {
        const response = await fetch(`${API_BASE}/groups`);
        const result = await response.json();
        
        if (result.success) {
            const emailGroupSelect = document.getElementById('email-group-select');
            emailGroupSelect.innerHTML = '<option value="">Choose a group...</option>';
            
            result.data.forEach(group => {
                const option = document.createElement('option');
                option.value = group.id;
                option.textContent = `${group.name} (${group.users_count || 0} members)`;
                option.dataset.memberCount = group.users_count || 0;
                emailGroupSelect.appendChild(option);
            });
        }
    } catch (error) {
        console.error('Error loading groups:', error);
        alert('Failed to load groups');
    }
}

// Update group info display
function updateGroupInfo() {
    const select = document.getElementById('email-group-select');
    const selectedOption = select.options[select.selectedIndex];
    const infoDiv = document.getElementById('group-info');
    
    if (select.value && selectedOption.dataset.memberCount) {
        const memberCount = selectedOption.dataset.memberCount;
        infoDiv.textContent = `This email will be sent to ${memberCount} member(s) in this group.`;
        infoDiv.className = 'mt-2 text-sm text-blue-600';
    } else {
        infoDiv.textContent = '';
    }
}

// Send Email
async function sendEmail(event) {
    event.preventDefault();
    
    // Validate editor has content
    const editorContent = quillEditor.root.innerHTML.trim();
    if (editorContent === '<p><br></p>' || editorContent === '') {
        alert('Please enter a message body');
        return;
    }
    
    const groupId = document.getElementById('email-group-select').value;
    const subject = document.getElementById('email-subject').value;
    // Get HTML content from Quill editor
    const body = editorContent;
    
    if (!confirm('Are you sure you want to send this email to all members of the selected group?')) {
        return;
    }
    
    const submitButton = event.target.querySelector('button[type="submit"]');
    const originalText = submitButton.textContent;
    submitButton.disabled = true;
    submitButton.textContent = 'Sending...';
    
    try {
        const response = await fetch(`${API_BASE}/groups/${groupId}/send-email`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ subject, body })
        });
        
        const result = await response.json();
        
        if (result.success) {
            alert(`Email sent successfully!\n\nSent to: ${result.data.sent} member(s)\nFailed: ${result.data.failed} member(s)`);
            document.getElementById('email-subject').value = '';
            quillEditor.setContents([]); // Clear editor
            document.getElementById('email-group-select').value = '';
            document.getElementById('group-info').textContent = '';
        } else {
            alert(result.message || 'Failed to send email');
        }
    } catch (error) {
        console.error('Error sending email:', error);
        alert('Failed to send email. Please check your connection and try again.');
    } finally {
        submitButton.disabled = false;
        submitButton.textContent = originalText;
    }
}
</script>
@endpush
@endsection

