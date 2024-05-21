# 東華大學資管系-電子商務期末專題

# 老師傅購物車實作

## XAMPP 安裝

![image](https://github.com/Sumo0711/old-master/blob/main/directions/1.png)

##### 網址：https://www.apachefriends.org/zh_tw/download.html

##### 選擇適合的作業系統

##### 這邊我是用最新的 8.2.4

## 檔案匯入

##### 將下載下來的資料夾放進 /Applications/XAMPP/xamppfiles/htdocs

##### 並把資料夾名稱改為 old-master

## 資料庫匯入

![image](https://github.com/Sumo0711/old-master/blob/main/directions/2.png)

##### 將 XAMPP 啟動

![image](https://github.com/Sumo0711/old-master/blob/main/directions/3.png)

##### 在瀏覽器打上 http://127.0.0.1/phpmyadmin/

![image](https://github.com/Sumo0711/old-master/blob/main/directions/4.png)

##### 將檔案中 SQL/old-master.sql 匯入資料庫

## 成品展示

##### 打開瀏覽器！ http://127.0.0.1/old-master/index.php

![image](https://github.com/Sumo0711/old-master/blob/main/directions/5.png)
![image](https://github.com/Sumo0711/old-master/blob/main/directions/6.png)
![image](https://github.com/Sumo0711/old-master/blob/main/directions/7.png)
![image](https://github.com/Sumo0711/old-master/blob/main/directions/8.png)
![image](https://github.com/Sumo0711/old-master/blob/main/directions/9.png)
![image](https://github.com/Sumo0711/old-master/blob/main/directions/10.png)

##### 內建一個測試帳號

##### 帳號：test

##### 密碼：test

##### 購物車內有放 10 個日式唐揚雞

## 結帳 API

##### 藍新科技測試區帳號

##### 網站：https://cwww.newebpay.com/

##### 測試卡號：4000-2211-1111-1111

## 功能展示

##### 按 header 的 老師傅會回到主商品頁面

##### 會員登入邏輯，當使用者沒登入不能查看購物車及下單

##### 會員註冊會從資料庫檢查是否有重複的是使用者

##### 檢查註冊密碼兩次都要相同

##### 檢查合法的手機號碼

##### 商品資訊都從資料庫讀入

##### 購物車會列出商品名稱、商品單價、數量、價格合計與總金額

##### 購物車有刪除單筆功能

##### 結帳串接金額至藍新科技的付款頁面

##### 從資料庫下架商品時，使用者購物車內有該項商品也會跟著刪除

## 備註

##### 老師只有說要做到 API 串接成功結帳

##### 所以確認訂單及退款功能沒有做

##### 結帳後商品並不會從購物車刪除！
