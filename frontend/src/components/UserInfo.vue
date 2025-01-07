<template>
  <div class="user-info">
    <h3>更多信息</h3>
    <p><strong>用户名:</strong> {{ user.login }}</p>
    <p><strong>创建时间:</strong> {{ formatDate(user.created_at) }}</p>
    <p><strong>公共仓库数:</strong> {{ user.public_repos }}</p>
    <p><strong>关注者:</strong> {{ user.followers }}</p>
    <p><strong>正在关注:</strong> {{ user.following }}</p>
    <p v-if="user.hireable"><strong>可接工作:</strong> 是</p>
    <p v-else><strong>可接工作:</strong> 否</p>

    <!-- Repository Stats -->
    <h4>仓库统计</h4>
    <p><strong>Star 总数:</strong> {{ totalStars }}</p>
    <p><strong>Fork 总数:</strong> {{ totalForks }}</p>
    <p><strong>公开 Issue 总数:</strong> {{ totalIssues }}</p>
  </div>
</template>

<script>
export default {
  props: {
    user: Object,
    repos: Array,
  },
  computed: {
    // 计算所有仓库的 star 数量
    totalStars() {
      return this.repos.reduce((acc, repo) => acc + repo.stargazers_count, 0);
    },
    // 计算所有仓库的 fork 数量
    totalForks() {
      return this.repos.reduce((acc, repo) => acc + repo.forks_count, 0);
    },
    // 计算所有公开仓库的 issue 数量
    totalIssues() {
      return this.repos.reduce((acc, repo) => acc + repo.open_issues_count, 0);
    },
  },
  methods: {
    formatDate(dateString) {
      const date = new Date(dateString);
      return `${date.getFullYear()}-${(date.getMonth() + 1).toString().padStart(2, '0')}-${date
        .getDate()
        .toString()
        .padStart(2, '0')}`;
    },
  },
};
</script>

<style scoped>
.user-info {
  margin-top: 20px;
  padding: 20px;  /* 增加内边距，提升可读性 */
  background: rgba(255, 255, 255, 0.9);  /* 改进卡片背景色 */
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
  border-radius: 12px;  /* 圆角提升大方感 */
}

.user-info h3,
.user-info h4 {
  margin-bottom: 15px;
  color: #333;
  font-size: 20px;
}

.user-info p {
  margin: 8px 0;
  font-size: 16px;  /* 增大字体提升阅读性 */
  color: #555;
}

/* 移动端适配 */
@media (max-width: 768px) {
  .user-info {
    padding: 15px;
  }

  .user-info h3,
  .user-info h4 {
    font-size: 18px;
  }

  .user-info p {
    font-size: 14px;
  }
}

@media (max-width: 480px) {
  .user-info {
    padding: 12px;
  }

  .user-info h3,
  .user-info h4 {
    font-size: 16px;
  }

  .user-info p {
    font-size: 12px;
  }
}
</style>
