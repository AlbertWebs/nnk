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
        
        <!-- Error Display Area -->
        <div id="error-display" class="hidden mb-6"></div>
        
        <!-- Success Display Area -->
        <div id="success-display" class="hidden mb-6"></div>
        
        <form id="send-email-form" onsubmit="showUserListModal(event)">
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
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Attachments (Optional)</label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-4">
                    <input type="file" id="email-attachments" multiple class="hidden" accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.gif,.txt,.zip,.rar">
                    <div class="flex items-center justify-center">
                        <button type="button" onclick="document.getElementById('email-attachments').click()" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            Choose Files
                        </button>
                    </div>
                    <p class="text-xs text-gray-500 text-center mt-2">You can attach multiple files (PDF, DOC, XLS, Images, etc.) - Max 10MB per file</p>
                    <div id="attachments-list" class="mt-4 space-y-2"></div>
                </div>
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
                <button type="submit" id="send-email-btn" class="px-6 py-2 bg-purple-500 hover:bg-purple-600 text-white rounded-lg flex items-center">
                    <span id="send-btn-text">Send Email</span>
                    <span id="send-btn-loading" class="hidden ml-2">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </span>
                    <span id="send-btn-success" class="hidden ml-2">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- User List Modal -->
<div id="user-list-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Confirm Email Recipients</h3>
                <button onclick="closeUserListModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div class="mb-4">
                <p class="text-sm text-gray-600 mb-2">
                    This email will be sent to <strong id="modal-member-count">0</strong> member(s) in <strong id="modal-group-name"></strong>:
                </p>
                <div id="modal-attachments-info" class="mb-3 p-3 bg-blue-50 border border-blue-200 rounded-lg hidden">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                        </svg>
                        <p class="text-sm text-blue-800">
                            <strong id="modal-attachment-count">0</strong> file(s) will be attached to this email
                        </p>
                    </div>
                </div>
                <div id="user-list-container" class="max-h-96 overflow-y-auto border border-gray-200 rounded-lg p-4 bg-gray-50">
                    <div class="text-center py-4">
                        <svg class="animate-spin h-8 w-8 text-purple-500 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <p class="mt-2 text-sm text-gray-500">Loading recipients...</p>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end space-x-3">
                <button onclick="closeUserListModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Cancel
                </button>
                <button id="confirm-send-btn" onclick="confirmSendEmail()" class="px-4 py-2 bg-purple-500 hover:bg-purple-600 text-white rounded-lg">
                    Confirm & Send
                </button>
            </div>
        </div>
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
    
    // Close modal when clicking outside
    const modal = document.getElementById('user-list-modal');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeUserListModal();
            }
        });
    }
    
    // Handle file selection
    const fileInput = document.getElementById('email-attachments');
    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            displayAttachments(e.target.files);
        });
    }
});

// Store selected files
let selectedFiles = [];

// Display selected attachments
function displayAttachments(files) {
    const attachmentsList = document.getElementById('attachments-list');
    attachmentsList.innerHTML = '';
    selectedFiles = Array.from(files);
    
    if (selectedFiles.length === 0) {
        return;
    }
    
    // Validate file sizes (10MB = 10485760 bytes)
    const maxSize = 10485760;
    const invalidFiles = selectedFiles.filter(file => file.size > maxSize);
    
    if (invalidFiles.length > 0) {
        alert(`Some files exceed the 10MB limit:\n${invalidFiles.map(f => f.name).join('\n')}\n\nThese files will be removed.`);
        selectedFiles = selectedFiles.filter(file => file.size <= maxSize);
        const fileInput = document.getElementById('email-attachments');
        const dataTransfer = new DataTransfer();
        selectedFiles.forEach(file => dataTransfer.items.add(file));
        fileInput.files = dataTransfer.files;
    }
    
    if (selectedFiles.length === 0) {
        return;
    }
    
    selectedFiles.forEach((file, index) => {
        const fileItem = document.createElement('div');
        fileItem.className = 'flex items-center justify-between p-2 bg-gray-50 rounded border border-gray-200';
        fileItem.innerHTML = `
            <div class="flex items-center flex-1 min-w-0">
                <svg class="w-5 h-5 text-gray-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <div class="flex-1 min-w-0">
                    <p class="text-sm text-gray-700 truncate" title="${file.name}">${file.name}</p>
                    <p class="text-xs text-gray-500">${formatFileSize(file.size)}</p>
                </div>
            </div>
            <button type="button" onclick="removeAttachment(${index})" class="ml-2 text-red-500 hover:text-red-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        `;
        attachmentsList.appendChild(fileItem);
    });
}

// Remove attachment
function removeAttachment(index) {
    selectedFiles.splice(index, 1);
    const fileInput = document.getElementById('email-attachments');
    const dataTransfer = new DataTransfer();
    selectedFiles.forEach(file => dataTransfer.items.add(file));
    fileInput.files = dataTransfer.files;
    displayAttachments(fileInput.files);
}

// Format file size
function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
}

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

// Show user list modal before sending
async function showUserListModal(event) {
    event.preventDefault();
    
    // Validate editor has content
    const editorContent = quillEditor.root.innerHTML.trim();
    if (editorContent === '<p><br></p>' || editorContent === '') {
        alert('Please enter a message body');
        return;
    }
    
    const groupId = document.getElementById('email-group-select').value;
    if (!groupId) {
        alert('Please select a group');
        return;
    }
    
    // Show modal
    const modal = document.getElementById('user-list-modal');
    modal.classList.remove('hidden');
    
    // Get selected group name
    const select = document.getElementById('email-group-select');
    const selectedOption = select.options[select.selectedIndex];
    const groupName = selectedOption.textContent.split(' (')[0];
    document.getElementById('modal-group-name').textContent = groupName;
    
    // Load and display users
    await loadGroupUsers(groupId);
}

// Load group users
async function loadGroupUsers(groupId) {
    const container = document.getElementById('user-list-container');
    
    // Show attachment info if files are selected
    const attachmentsInfo = document.getElementById('modal-attachments-info');
    const attachmentCount = document.getElementById('modal-attachment-count');
    if (selectedFiles.length > 0) {
        attachmentsInfo.classList.remove('hidden');
        attachmentCount.textContent = selectedFiles.length;
    } else {
        attachmentsInfo.classList.add('hidden');
    }
    
    try {
        const response = await fetch(`${API_BASE}/groups/${groupId}`);
        const result = await response.json();
        
        if (result.success && result.data) {
            const users = result.data.users || [];
            document.getElementById('modal-member-count').textContent = users.length;
            
            if (users.length === 0) {
                container.innerHTML = '<p class="text-center text-gray-500 py-4">No members in this group.</p>';
                document.getElementById('confirm-send-btn').disabled = true;
                return;
            }
            
            document.getElementById('confirm-send-btn').disabled = false;
            
            // Display users
            let html = '<div class="space-y-2">';
            users.forEach((user, index) => {
                html += `
                    <div class="flex items-center p-2 bg-white rounded border border-gray-200">
                        <div class="flex-shrink-0 w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center text-purple-600 font-medium text-sm">
                            ${index + 1}
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-medium text-gray-900">${user.name || 'No name'}</p>
                            <p class="text-sm text-gray-500">${user.email}</p>
                        </div>
                    </div>
                `;
            });
            html += '</div>';
            container.innerHTML = html;
        } else {
            container.innerHTML = '<p class="text-center text-red-500 py-4">Failed to load group members.</p>';
            document.getElementById('confirm-send-btn').disabled = true;
        }
    } catch (error) {
        console.error('Error loading group users:', error);
        container.innerHTML = '<p class="text-center text-red-500 py-4">Error loading group members.</p>';
        document.getElementById('confirm-send-btn').disabled = true;
    }
}

// Close user list modal
function closeUserListModal() {
    const modal = document.getElementById('user-list-modal');
    modal.classList.add('hidden');
}

// Confirm and send email
async function confirmSendEmail() {
    closeUserListModal();
    
    const groupId = document.getElementById('email-group-select').value;
    const subject = document.getElementById('email-subject').value;
    const body = quillEditor.root.innerHTML.trim();
    
    const submitButton = document.getElementById('send-email-btn');
    const btnText = document.getElementById('send-btn-text');
    const btnLoading = document.getElementById('send-btn-loading');
    const btnSuccess = document.getElementById('send-btn-success');
    const successDisplay = document.getElementById('success-display');
    const errorDisplay = document.getElementById('error-display');
    
    // Hide previous messages
    successDisplay.classList.add('hidden');
    successDisplay.innerHTML = '';
    errorDisplay.classList.add('hidden');
    errorDisplay.innerHTML = '';
    
    // Show loading state
    submitButton.disabled = true;
    btnText.textContent = 'Sending...';
    btnLoading.classList.remove('hidden');
    btnSuccess.classList.add('hidden');
    
    try {
        // Create FormData for file uploads
        const formData = new FormData();
        formData.append('subject', subject);
        formData.append('body', body);
        
        // Add attachments if any
        if (selectedFiles.length > 0) {
            selectedFiles.forEach((file, index) => {
                formData.append(`attachments[${index}]`, file);
            });
        }
        
        const response = await fetch(`${API_BASE}/groups/${groupId}/send-email`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
            // Show success state
            btnText.textContent = 'Email Sent!';
            btnLoading.classList.add('hidden');
            btnSuccess.classList.remove('hidden');
            
            // Show success message
            showSuccessMessage(result.data);
            
            // Clear form after 2 seconds
            setTimeout(() => {
                document.getElementById('email-subject').value = '';
                quillEditor.setContents([]);
                document.getElementById('email-group-select').value = '';
                document.getElementById('group-info').textContent = '';
                
                // Clear attachments
                selectedFiles = [];
                document.getElementById('email-attachments').value = '';
                document.getElementById('attachments-list').innerHTML = '';
                
                // Reset button
                submitButton.disabled = false;
                btnText.textContent = 'Send Email';
                btnSuccess.classList.add('hidden');
            }, 3000);
            
            // Show errors if any
            if (result.data.errors && result.data.errors.length > 0) {
                showErrors(result.data.errors, result.data);
            }
        } else {
            // Show error state
            submitButton.disabled = false;
            btnText.textContent = 'Send Email';
            btnLoading.classList.add('hidden');
            btnSuccess.classList.add('hidden');
            
            // Show validation or general errors
            if (result.errors) {
                showValidationErrors(result.errors, result.message);
            } else {
                showError(result.message || result.error || 'Failed to send email');
            }
        }
    } catch (error) {
        console.error('Error sending email:', error);
        
        // Reset button
        submitButton.disabled = false;
        btnText.textContent = 'Send Email';
        btnLoading.classList.add('hidden');
        btnSuccess.classList.add('hidden');
        
        showError('Failed to send email. Please check your connection and try again.');
    }
}

// Show errors from failed email sends
function showErrors(errors, data) {
    const errorDisplay = document.getElementById('error-display');
    errorDisplay.classList.remove('hidden');
    
    let html = `
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-blue-600 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="flex-1">
                    <p class="text-sm font-medium text-blue-800">
                        Email sent to ${data.sent} member(s), but ${data.failed} failed
                    </p>
                </div>
            </div>
        </div>
    `;
    
    if (errors.length > 0) {
        html += `
            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-red-600 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-red-800 mb-2">Failed Email Deliveries:</p>
                        <ul class="list-disc list-inside space-y-1 text-sm text-red-700">
        `;
        
        errors.forEach(error => {
            const userName = error.user_name ? ` (${error.user_name})` : '';
            html += `<li><strong>${error.user}${userName}:</strong> ${error.error}</li>`;
        });
        
        html += `
                        </ul>
                    </div>
                </div>
            </div>
        `;
    }
    
    errorDisplay.innerHTML = html;
    
    // Scroll to error display
    errorDisplay.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

// Show validation errors
function showValidationErrors(errors, message) {
    const errorDisplay = document.getElementById('error-display');
    errorDisplay.classList.remove('hidden');
    
    let html = `
        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-red-600 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="flex-1">
                    <p class="text-sm font-medium text-red-800 mb-2">${message || 'Validation Error'}</p>
                    <ul class="list-disc list-inside space-y-1 text-sm text-red-700">
    `;
    
    if (typeof errors === 'object') {
        Object.keys(errors).forEach(key => {
            errors[key].forEach(errorMsg => {
                html += `<li><strong>${key}:</strong> ${errorMsg}</li>`;
            });
        });
    }
    
    html += `
                    </ul>
                </div>
            </div>
        </div>
    `;
    
    errorDisplay.innerHTML = html;
    errorDisplay.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

// Show general error
function showError(message) {
    const errorDisplay = document.getElementById('error-display');
    errorDisplay.classList.remove('hidden');
    
    errorDisplay.innerHTML = `
        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-red-600 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="flex-1">
                    <p class="text-sm font-medium text-red-800">${message}</p>
                </div>
            </div>
        </div>
    `;
    
    errorDisplay.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

// Show success message
function showSuccessMessage(data) {
    const successDisplay = document.getElementById('success-display');
    successDisplay.classList.remove('hidden');
    
    let html = `
        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-green-600 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="flex-1">
                    <p class="text-sm font-medium text-green-800">
                        Email sent successfully to ${data.sent} member(s)${data.failed > 0 ? ` (${data.failed} failed)` : ''}!
                    </p>
                </div>
            </div>
        </div>
    `;
    
    successDisplay.innerHTML = html;
    successDisplay.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}
</script>
@endpush
@endsection

