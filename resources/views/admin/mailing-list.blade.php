@extends('admin.layout')

@section('title', 'Mailing List')
@section('page-title', 'Mailing List Management')

@push('styles')
<style>
    .group-card, .user-card {
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 1rem;
        background: white;
    }
    .member-badge {
        display: inline-block;
        background: #3b82f6;
        color: white;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.75rem;
        margin: 0.25rem;
    }
</style>
@endpush

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Groups Section -->
    <div>
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Groups</h2>
            <button onclick="showCreateGroupModal()" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">
                + New Group
            </button>
        </div>
        <div id="groups-list" class="space-y-3">
            <!-- Groups will be loaded here -->
        </div>
    </div>

    <!-- Users Section -->
    <div>
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Users</h2>
            <button onclick="showCreateUserModal()" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm">
                + New User
            </button>
        </div>
        <div id="users-list" class="space-y-3">
            <!-- Users will be loaded here -->
        </div>
        <!-- Pagination Controls -->
        <div id="users-pagination" class="mt-4 flex justify-center items-center space-x-2">
            <!-- Pagination will be generated here -->
        </div>
    </div>
</div>

<!-- Create Group Modal -->
<div id="create-group-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <h3 class="text-lg font-semibold mb-4">Create New Group</h3>
        <form onsubmit="createGroup(event)">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Group Name</label>
                <input type="text" id="group-name" required class="w-full px-3 py-2 border border-gray-300 rounded-lg">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Description (Optional)</label>
                <textarea id="group-description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg"></textarea>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeModal('create-group-modal')" class="px-4 py-2 border border-gray-300 rounded-lg">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Create</button>
            </div>
        </form>
    </div>
</div>

<!-- Create User Modal -->
<div id="create-user-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4 max-h-[90vh] overflow-y-auto">
        <h3 class="text-lg font-semibold mb-4">Create New User</h3>
        <form onsubmit="createUser(event)">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                <input type="text" id="user-name" required class="w-full px-3 py-2 border border-gray-300 rounded-lg">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" id="user-email" required class="w-full px-3 py-2 border border-gray-300 rounded-lg">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Add to Groups (Optional)</label>
                <div id="create-user-groups" class="border border-gray-300 rounded-lg p-3 max-h-40 overflow-y-auto">
                    <p class="text-sm text-gray-500">Loading groups...</p>
                </div>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeModal('create-user-modal')" class="px-4 py-2 border border-gray-300 rounded-lg">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-lg">Create</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit User Modal -->
<div id="edit-user-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4 max-h-[90vh] overflow-y-auto">
        <h3 class="text-lg font-semibold mb-4">Edit User</h3>
        <form onsubmit="updateUser(event)">
            <input type="hidden" id="edit-user-id">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                <input type="text" id="edit-user-name" required class="w-full px-3 py-2 border border-gray-300 rounded-lg">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" id="edit-user-email" required class="w-full px-3 py-2 border border-gray-300 rounded-lg">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Groups</label>
                <div id="edit-user-groups" class="border border-gray-300 rounded-lg p-3 max-h-40 overflow-y-auto">
                    <p class="text-sm text-gray-500">Loading groups...</p>
                </div>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeModal('edit-user-modal')" class="px-4 py-2 border border-gray-300 rounded-lg">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Update</button>
            </div>
        </form>
    </div>
</div>

<!-- Add User to Group Modal -->
<div id="add-user-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <h3 class="text-lg font-semibold mb-4">Add User to Group</h3>
        <form onsubmit="addUserToGroup(event)">
            <input type="hidden" id="modal-group-id">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Select User</label>
                <select id="modal-user-select" required class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                    <option value="">Choose a user...</option>
                </select>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeModal('add-user-modal')" class="px-4 py-2 border border-gray-300 rounded-lg">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Add</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
const API_BASE = '/api/mailing-list';

// Global variable to store groups for modals
let allGroups = [];

// Load data on page load
document.addEventListener('DOMContentLoaded', function() {
    loadGroups();
    loadUsers();
});

// Load Groups
async function loadGroups() {
    try {
        const response = await fetch(`${API_BASE}/groups`);
        const result = await response.json();
        
        if (result.success) {
            allGroups = result.data;
            const groupsList = document.getElementById('groups-list');
            
            if (groupsList) {
                groupsList.innerHTML = '';
                
                result.data.forEach(group => {
                    // Add to groups list
                    const groupCard = document.createElement('div');
                    groupCard.className = 'group-card';
                    groupCard.innerHTML = `
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-800">${escapeHtml(group.name)}</h3>
                                ${group.description ? `<p class="text-sm text-gray-600 mt-1">${escapeHtml(group.description)}</p>` : ''}
                                <p class="text-xs text-gray-500 mt-2">${group.users_count || 0} member(s)</p>
                            </div>
                            <div class="flex space-x-2">
                                <button onclick="showAddUserModal(${group.id})" class="text-blue-600 hover:text-blue-800 text-sm">Add User</button>
                                <button onclick="deleteGroup(${group.id})" class="text-red-600 hover:text-red-800 text-sm">Delete</button>
                            </div>
                        </div>
                    `;
                    groupsList.appendChild(groupCard);
                });
            }
            
            // Update group checkboxes in modals
            updateGroupCheckboxes();
        }
    } catch (error) {
        console.error('Error loading groups:', error);
        alert('Failed to load groups');
    }
}

// Update group checkboxes in create and edit modals
function updateGroupCheckboxes() {
    // Create user modal
    const createGroupsDiv = document.getElementById('create-user-groups');
    if (createGroupsDiv) {
        if (allGroups.length === 0) {
            createGroupsDiv.innerHTML = '<p class="text-sm text-gray-500">No groups available. Create a group first.</p>';
        } else {
            createGroupsDiv.innerHTML = allGroups.map(group => `
                <label class="flex items-center mb-2 cursor-pointer hover:bg-gray-50 p-2 rounded">
                    <input type="checkbox" name="user-groups" value="${group.id}" class="mr-2 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="text-sm text-gray-700">${escapeHtml(group.name)}</span>
                </label>
            `).join('');
        }
    }
    
    // Edit user modal - only update if modal is open and has user data
    const editGroupsDiv = document.getElementById('edit-user-groups');
    if (editGroupsDiv && editGroupsDiv.dataset.userGroups) {
        const userGroupIds = JSON.parse(editGroupsDiv.dataset.userGroups);
        if (allGroups.length === 0) {
            editGroupsDiv.innerHTML = '<p class="text-sm text-gray-500">No groups available.</p>';
        } else {
            editGroupsDiv.innerHTML = allGroups.map(group => `
                <label class="flex items-center mb-2 cursor-pointer hover:bg-gray-50 p-2 rounded">
                    <input type="checkbox" name="edit-user-groups" value="${group.id}" 
                           ${userGroupIds.includes(group.id) ? 'checked' : ''}
                           class="mr-2 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="text-sm text-gray-700">${escapeHtml(group.name)}</span>
                </label>
            `).join('');
        }
    } else if (editGroupsDiv && !editGroupsDiv.dataset.userGroups) {
        // Initialize empty if no user data yet
        if (allGroups.length === 0) {
            editGroupsDiv.innerHTML = '<p class="text-sm text-gray-500">No groups available.</p>';
        } else {
            editGroupsDiv.innerHTML = allGroups.map(group => `
                <label class="flex items-center mb-2 cursor-pointer hover:bg-gray-50 p-2 rounded">
                    <input type="checkbox" name="edit-user-groups" value="${group.id}" 
                           class="mr-2 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="text-sm text-gray-700">${escapeHtml(group.name)}</span>
                </label>
            `).join('');
        }
    }
}

// Global variables for pagination
let allUsers = [];
let currentPage = 1;
const usersPerPage = 10;

// Load Users
async function loadUsers() {
    try {
        const response = await fetch(`${API_BASE}/users`);
        const result = await response.json();
        
        if (result.success) {
            allUsers = result.data;
            const modalUserSelect = document.getElementById('modal-user-select');
            
            // Populate modal select with all users
            modalUserSelect.innerHTML = '<option value="">Choose a user...</option>';
            allUsers.forEach(user => {
                const option = document.createElement('option');
                option.value = user.id;
                option.textContent = `${user.name} (${user.email})`;
                modalUserSelect.appendChild(option);
            });
            
            // Display first page
            displayUsersPage(1);
        }
    } catch (error) {
        console.error('Error loading users:', error);
        alert('Failed to load users');
    }
}

// Display users for a specific page
function displayUsersPage(page) {
    currentPage = page;
    const usersList = document.getElementById('users-list');
    const startIndex = (page - 1) * usersPerPage;
    const endIndex = startIndex + usersPerPage;
    const pageUsers = allUsers.slice(startIndex, endIndex);
    
    usersList.innerHTML = '';
    
    if (pageUsers.length === 0) {
        usersList.innerHTML = '<p class="text-gray-500 text-center py-4">No users found</p>';
    } else {
        pageUsers.forEach(user => {
            const userCard = document.createElement('div');
            userCard.className = 'user-card';
            userCard.innerHTML = `
                <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-semibold text-gray-800">${escapeHtml(user.name)}</h3>
                            <p class="text-sm text-gray-600">${escapeHtml(user.email)}</p>
                            ${user.groups && user.groups.length > 0 ? `
                                <div class="mt-2">
                                    ${user.groups.map(g => `<span class="member-badge">${escapeHtml(g.name)}</span>`).join('')}
                                </div>
                            ` : ''}
                        </div>
                        <div class="flex space-x-2">
                            <button onclick="showEditUserModal(${user.id})" class="text-blue-600 hover:text-blue-800 text-sm">Edit</button>
                            <button onclick="deleteUser(${user.id})" class="text-red-600 hover:text-red-800 text-sm">Delete</button>
                        </div>
                </div>
            `;
            usersList.appendChild(userCard);
        });
    }
    
    // Update pagination controls
    updatePaginationControls();
}

// Update pagination controls
function updatePaginationControls() {
    const totalPages = Math.ceil(allUsers.length / usersPerPage);
    const paginationDiv = document.getElementById('users-pagination');
    
    if (totalPages <= 1) {
        paginationDiv.innerHTML = '';
        return;
    }
    
    let paginationHTML = '';
    
    // Previous button
    if (currentPage > 1) {
        paginationHTML += `<button onclick="displayUsersPage(${currentPage - 1})" class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-100">Previous</button>`;
    } else {
        paginationHTML += `<button disabled class="px-3 py-1 border border-gray-300 rounded text-gray-400 cursor-not-allowed">Previous</button>`;
    }
    
    // Page numbers
    const maxVisiblePages = 5;
    let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
    let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);
    
    if (endPage - startPage < maxVisiblePages - 1) {
        startPage = Math.max(1, endPage - maxVisiblePages + 1);
    }
    
    if (startPage > 1) {
        paginationHTML += `<button onclick="displayUsersPage(1)" class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-100">1</button>`;
        if (startPage > 2) {
            paginationHTML += `<span class="px-2">...</span>`;
        }
    }
    
    for (let i = startPage; i <= endPage; i++) {
        if (i === currentPage) {
            paginationHTML += `<button class="px-3 py-1 bg-blue-500 text-white rounded">${i}</button>`;
        } else {
            paginationHTML += `<button onclick="displayUsersPage(${i})" class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-100">${i}</button>`;
        }
    }
    
    if (endPage < totalPages) {
        if (endPage < totalPages - 1) {
            paginationHTML += `<span class="px-2">...</span>`;
        }
        paginationHTML += `<button onclick="displayUsersPage(${totalPages})" class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-100">${totalPages}</button>`;
    }
    
    // Next button
    if (currentPage < totalPages) {
        paginationHTML += `<button onclick="displayUsersPage(${currentPage + 1})" class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-100">Next</button>`;
    } else {
        paginationHTML += `<button disabled class="px-3 py-1 border border-gray-300 rounded text-gray-400 cursor-not-allowed">Next</button>`;
    }
    
    // Page info
    const startIndex = (currentPage - 1) * usersPerPage + 1;
    const endIndex = Math.min(currentPage * usersPerPage, allUsers.length);
    paginationHTML += `<span class="text-sm text-gray-600 ml-4">Showing ${startIndex}-${endIndex} of ${allUsers.length}</span>`;
    
    paginationDiv.innerHTML = paginationHTML;
}

// Create Group
async function createGroup(event) {
    event.preventDefault();
    const name = document.getElementById('group-name').value;
    const description = document.getElementById('group-description').value;
    
    try {
        const response = await fetch(`${API_BASE}/groups`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ name, description })
        });
        
        const result = await response.json();
        
        if (result.success) {
            closeModal('create-group-modal');
            document.getElementById('group-name').value = '';
            document.getElementById('group-description').value = '';
            loadGroups();
            alert('Group created successfully!');
        } else {
            alert(result.message || 'Failed to create group');
        }
    } catch (error) {
        console.error('Error creating group:', error);
        alert('Failed to create group');
    }
}

// Create User
async function createUser(event) {
    event.preventDefault();
    const name = document.getElementById('user-name').value;
    const email = document.getElementById('user-email').value;
    
    // Get selected groups
    const selectedGroups = Array.from(document.querySelectorAll('#create-user-groups input[type="checkbox"]:checked'))
        .map(cb => parseInt(cb.value));
    
    try {
        const response = await fetch(`${API_BASE}/users`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ 
                name, 
                email,
                groups: selectedGroups
            })
        });
        
        const result = await response.json();
        
        if (result.success) {
            closeModal('create-user-modal');
            document.getElementById('user-name').value = '';
            document.getElementById('user-email').value = '';
            // Clear checkboxes
            document.querySelectorAll('#create-user-groups input[type="checkbox"]').forEach(cb => cb.checked = false);
            reloadUsers();
            alert('User created successfully!');
        } else {
            alert(result.message || 'Failed to create user');
        }
    } catch (error) {
        console.error('Error creating user:', error);
        alert('Failed to create user');
    }
}

// Show Edit User Modal
async function showEditUserModal(userId) {
    try {
        const response = await fetch(`${API_BASE}/users/${userId}`);
        const result = await response.json();
        
        if (result.success) {
            const user = result.data;
            document.getElementById('edit-user-id').value = user.id;
            document.getElementById('edit-user-name').value = user.name;
            document.getElementById('edit-user-email').value = user.email;
            
            // Set user groups for checkbox rendering
            const editGroupsDiv = document.getElementById('edit-user-groups');
            const userGroupIds = user.groups ? user.groups.map(g => g.id) : [];
            editGroupsDiv.dataset.userGroups = JSON.stringify(userGroupIds);
            
            // Update checkboxes
            updateGroupCheckboxes();
            
            // Open modal
            document.getElementById('edit-user-modal').classList.remove('hidden');
        } else {
            alert('Failed to load user data');
        }
    } catch (error) {
        console.error('Error loading user:', error);
        alert('Failed to load user data');
    }
}

// Update User
async function updateUser(event) {
    event.preventDefault();
    const userId = document.getElementById('edit-user-id').value;
    const name = document.getElementById('edit-user-name').value;
    const email = document.getElementById('edit-user-email').value;
    
    // Get selected groups
    const selectedGroups = Array.from(document.querySelectorAll('#edit-user-groups input[type="checkbox"]:checked'))
        .map(cb => parseInt(cb.value));
    
    try {
        const response = await fetch(`${API_BASE}/users/${userId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ 
                name, 
                email,
                groups: selectedGroups
            })
        });
        
        const result = await response.json();
        
        if (result.success) {
            closeModal('edit-user-modal');
            reloadUsers();
            alert('User updated successfully!');
        } else {
            alert(result.message || 'Failed to update user');
        }
    } catch (error) {
        console.error('Error updating user:', error);
        alert('Failed to update user');
    }
}

// Add User to Group
async function addUserToGroup(event) {
    event.preventDefault();
    const groupId = document.getElementById('modal-group-id').value;
    const userId = document.getElementById('modal-user-select').value;
    
    try {
        const response = await fetch(`${API_BASE}/groups/${groupId}/add-user/${userId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        
        const result = await response.json();
        
        if (result.success) {
            closeModal('add-user-modal');
            loadGroups();
            reloadUsers();
            alert('User added to group successfully!');
        } else {
            alert(result.message || 'Failed to add user to group');
        }
    } catch (error) {
        console.error('Error adding user to group:', error);
        alert('Failed to add user to group');
    }
}

// Reload users after operations
function reloadUsers() {
    loadUsers();
}

// Delete Group
async function deleteGroup(id) {
    if (!confirm('Are you sure you want to delete this group?')) {
        return;
    }
    
    try {
        const response = await fetch(`${API_BASE}/groups/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        
        const result = await response.json();
        
        if (result.success) {
            loadGroups();
            alert('Group deleted successfully!');
        } else {
            alert(result.message || 'Failed to delete group');
        }
    } catch (error) {
        console.error('Error deleting group:', error);
        alert('Failed to delete group');
    }
}

// Delete User
async function deleteUser(id) {
    if (!confirm('Are you sure you want to delete this user?')) {
        return;
    }
    
    try {
        const response = await fetch(`${API_BASE}/users/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        
        const result = await response.json();
        
        if (result.success) {
            reloadUsers();
            alert('User deleted successfully!');
        } else {
            alert(result.message || 'Failed to delete user');
        }
    } catch (error) {
        console.error('Error deleting user:', error);
        alert('Failed to delete user');
    }
}

// Modal functions
function showCreateGroupModal() {
    document.getElementById('create-group-modal').classList.remove('hidden');
}

function showCreateUserModal() {
    // Ensure groups are loaded
    if (allGroups.length === 0) {
        loadGroups().then(() => {
            updateGroupCheckboxes();
            document.getElementById('create-user-modal').classList.remove('hidden');
        });
    } else {
        updateGroupCheckboxes();
        document.getElementById('create-user-modal').classList.remove('hidden');
    }
}

function showAddUserModal(groupId) {
    document.getElementById('modal-group-id').value = groupId;
    document.getElementById('add-user-modal').classList.remove('hidden');
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
    // Clear edit user data when closing edit modal
    if (modalId === 'edit-user-modal') {
        const editGroupsDiv = document.getElementById('edit-user-groups');
        if (editGroupsDiv) {
            delete editGroupsDiv.dataset.userGroups;
        }
    }
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}
</script>
@endpush
@endsection

