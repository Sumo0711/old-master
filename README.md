# 東華大學資管系-電子商務期末專題

# 老師傅購物車實作

## XAMPP 安裝

![image](https://github.com/Sumo0711/old-master/blob/main/directions/1.png)

網址：https://www.apachefriends.org/zh_tw/download.html

選擇適合的作業系統

這邊我是用 MAC 版最新的 8.2.4

## 檔案匯入

將下載下來的資料夾放進 /Applications/XAMPP/xamppfiles/htdocs

## 資料庫匯入

![image](https://github.com/Sumo0711/old-master/blob/main/directions/2.png)

將 XAMPP 啟動

![image](https://github.com/Sumo0711/old-master/blob/main/directions/3.png)

在瀏覽器打上 http://127.0.0.1/phpmyadmin/

![image](https://github.com/Sumo0711/old-master/blob/main/directions/4.png)

將檔案中 SQL/old-master.sql 匯入資料庫

## 前台功能展示

打開瀏覽器！ http://127.0.0.1/old-master/index.php

![image](https://github.com/Sumo0711/old-master/blob/main/directions/5.png)
按 header 的 老師傅會回到主商品頁面  
![image](https://github.com/Sumo0711/old-master/blob/main/directions/8.png)
按下商品會跳轉到商品頁面

可以選擇下單數量

會員登入邏輯，當使用者沒登入不能查看購物車及下單  
![image](https://github.com/Sumo0711/old-master/blob/main/directions/6.png)
登入時檢查有沒有該名使用者，如果沒有跳錯誤訊息

內建一個測試帳號

帳號：test

密碼：test

購物車內有放 1 個日式雞排飯  
![image](https://github.com/Sumo0711/old-master/blob/main/directions/7.png)
會員註冊會從資料庫檢查是否有重複的使用者

檢查註冊密碼兩次都要相同

檢查合法的手機號碼  
![image](https://github.com/Sumo0711/old-master/blob/main/directions/9.png)
每個使用者都有獨立的購物車

購物車會列出商品名稱、商品單價、數量、價格合計與總金額

購物車有刪除單筆功能  
![image](https://github.com/Sumo0711/old-master/blob/main/directions/11.png)
結帳前會跳出取餐號碼

結帳後商品會從購物車刪除  
![image](https://github.com/Sumo0711/old-master/blob/main/directions/10.png)
串接金額至藍新科技的付款頁面

測試卡號：4000-2211-1111-1111

合理的有效年月，例如：05/30

合理的背面末三碼，例如：111

email 可隨便填寫，但後面要是 @gmail.com

勾選兩項同意並送出  
![image](https://github.com/Sumo0711/old-master/blob/main/directions/19.png)
成功付款！

## 後台功能展示

打開瀏覽器！ http://127.0.0.1/old-master/admin.php
![image](https://github.com/Sumo0711/old-master/blob/main/directions/12.png)
開店能把所有商品上架  
![image](https://github.com/Sumo0711/old-master/blob/main/directions/13.png)
關店把所有商品下架並跳轉關店頁面

從資料庫刪除商品時，使用者購物車內有該項商品也會跟著刪除
![image](https://github.com/Sumo0711/old-master/blob/main/directions/14.png)
每個商品都有完售按鈕，可獨立控制商品是否完售
![image](https://github.com/Sumo0711/old-master/blob/main/directions/15.png)
完售後前台使用者便無法在下訂單  
![image](https://github.com/Sumo0711/old-master/blob/main/directions/16.png)
餐點管理，能看到現在所有需要出餐的訂單

按 header 的 管理員控制台會回到管理員控制台頁面

按下完成訂單後會跑到歷史訂單  
![image](https://github.com/Sumo0711/old-master/blob/main/directions/17.png)
歷史訂單按復原即可回到目前訂單（防誤觸）
![image](https://github.com/Sumo0711/old-master/blob/main/directions/18.png)
總營收會紀錄到如今歷史訂單的總收入

## 結帳 API

藍新科技測試區

網站：https://cwww.newebpay.com/

測試區帳號：oldmaster

測試區密碼：123456aaa

## 備註

這裡不考慮資安問題，所以後台沒有設定管理員身份驗證

因為是本地測試環境，串接到藍新科技後，回不到本機

故無法確認使用者是否成功付款

這裡使用的邏輯是，當使用者按下結帳，就判定為成功付款
