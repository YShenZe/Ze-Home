<template>
  <el-container>
    <el-header>
      <div class="header-content">
        <el-avatar :src="user?.avatar_url || ''" size="large" class="avatar-blur" />
        <div class="user-details">
          <h1>{{ user?.name || '加载中...' }}</h1>
          <p class="bio">{{ user?.bio || '请稍等，正在加载用户信息...' }}</p>
        </div>
      </div>
    </el-header>

    <el-main>
      <!-- 用户信息占位符 -->
      <el-card v-if="!user" class="user-card">
        <el-skeleton :rows="4" animated />
      </el-card>

      <!-- 用户信息加载完成 -->
      <el-card v-if="user" class="user-card">
        <UserInfo :user="user" :repos="repos" />
      </el-card>

      <!-- 仓库信息占位符 -->
      <el-row :gutter="20" class="repo-row" v-if="!repos.length && user">
        <el-col :span="24" v-for="index in 3" :key="index" class="repo-col">
          <el-card class="repo-card">
            <el-skeleton :rows="3" animated />
          </el-card>
        </el-col>
      </el-row>

      <!-- 仓库信息加载完成 -->
      <el-row :gutter="20" class="repo-row" v-if="repos.length">
        <el-col :span="8" v-for="repo in repos" :key="repo.id" class="repo-col">
          <el-card shadow="always" class="repo-card">
            <h3>{{ repo.name }}</h3>
            <p class="repo-description">{{ repo.description }}</p>
            <div class="repo-stats">
              <p><strong>Star:</strong> {{ repo.stargazers_count }}</p>
              <p><strong>Fork:</strong> {{ repo.forks_count }}</p>
              <p><strong>Open Issues:</strong> {{ repo.open_issues_count }}</p>
            </div>
          </el-card>
        </el-col>
      </el-row>
    </el-main>
  </el-container>
</template>

<script>
import { ref } from "vue";
import UserInfo from "./components/UserInfo.vue";

export default {
  components: { UserInfo },
  setup() {
    const username = ref("YShenZe");
    const user = ref(null);
    const repos = ref([]);

    const fetchData = async () => {
      try {
        const userRes = await fetch(`/api/user?username=${username.value}`);
        user.value = await userRes.json();

        const reposRes = await fetch(`/api/repos?username=${username.value}`);
        repos.value = await reposRes.json();
      } catch (error) {
        console.error("数据获取失败:", error);
      }
    };

    fetchData();
    return { username, user, repos };
  },
};
</script>

<style scoped>
/* 通用布局 */
.header-content {
  display: flex;
  align-items: center;
  gap: 20px;
  margin-bottom: 20px;
  padding: 15px;
  justify-content: center;
}

.user-details {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.bio {
  font-size: 14px;
  color: #666;
  text-align: center;
}

.avatar-blur {
  width: 80px;
  height: 80px;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.6);
  filter: blur(1px);
}

.user-card {
  margin-bottom: 20px;
  padding: 20px;
}

.repo-card {
  padding: 15px;
  font-size: 14px;
  transition: all 0.3s ease-in-out;
}

.repo-stats {
  margin-top: 10px;
  font-size: 12px;
  color: #777;
}

.repo-description {
  color: #555;
  margin-bottom: 10px;
}

/* 移动端适配：最大宽度 768px */
@media (max-width: 768px) {
  .header-content {
    flex-direction: column;
    gap: 20px;
    align-items: center;
  }

  .avatar-blur {
    width: 70px;
    height: 70px;
  }

  .user-details {
    text-align: center;
  }

  .bio {
    font-size: 13px;
  }

  .repo-card {
    margin-bottom: 20px;
    padding: 15px;
    font-size: 14px;
  }

  .repo-stats {
    font-size: 12px;
  }
}

/* 移动端适配：最大宽度 480px */
@media (max-width: 480px) {
  .header-content {
    flex-direction: column;
    gap: 15px;
  }

  .avatar-blur {
    width: 60px;
    height: 60px;
  }

  .bio {
    font-size: 12px;
  }

  h1 {
    font-size: 18px;
    text-align: center;
  }

  .repo-card {
    padding: 12px;
    font-size: 12px;
  }

  .repo-stats {
    font-size: 10px;
  }

  .user-card {
    padding: 15px;
  }
}
</style>
