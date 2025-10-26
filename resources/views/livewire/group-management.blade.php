<div class="group-management-page">
    <div class="container">
        <main class="main-content">
            <div class="chat-header group">
                <div class="left-section">
                    <div class="group-info">
                        <img src="{{ getAvatar($this->group->name) }}" alt="{{ $this->group->name }}"
                            class="group-main-avatar">
                        <div class="group-text">
                            <h2 class="chat-name">{{ $this->group->name }}</h2>
                            <p class="member-count-summary">{{ count($this->group->members) }} members</p>
                            <div class="group-members-summary">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="right-section">
                    <button class="btn btn-primary" id="viewAllMembersBtn">
                        <i class="fas fa-users"></i> View All Members
                    </button>
                </div>
            </div>

            <div class="group-management-panel">

                <div class="panel-section member-list-section">
                    <h3>Member List</h3>
                    <div class="search-box">
                        <input type="text" id="memberSearch" placeholder="Search members...">
                        <i class="fas fa-search"></i>
                    </div>
                    <ul class="member-list" id="memberList">
                    </ul>
                </div>

                <div class="panel-section add-member-section">
                    <h3>Add Member</h3>
                    <div class="search-box">
                        <input type="text" id="addMemberSearch" placeholder="Search user to add...">
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="suggested-users-container">
                        <h4>Suggested Users</h4>
                        <ul class="suggested-users" id="suggestedUsersList">
                        </ul>
                    </div>
                </div>

                <div class="panel-section group-settings-section">
                    <h3>Group Settings</h3>
                    <ul class="settings-list">
                        <li>
                            <span>Admin Only Posts</span>
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider round"></span>
                            </label>
                        </li>
                        <li>
                            <span>Mute Notifications</span>
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider round"></span>
                            </label>
                        </li>
                        <li>
                            <button class="btn btn-danger leave-group-btn">
                                <i class="fas fa-sign-out-alt"></i> Leave Group
                            </button>
                        </li>
                    </ul>
                </div>
            </div>

        </main>

    </div>
</div>
