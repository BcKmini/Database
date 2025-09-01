# 🏥 종합 의료 관리 서비스 

[![Backend-PHP](https://img.shields.io/badge/Backend-PHP-777BB4?logo=php&logoColor=white)](#기술-스택)
[![Database-MySQL](https://img.shields.io/badge/Database-MySQL-4479A1?logo=mysql&logoColor=white)](#데이터-모델erd)
[![Frontend-HTML/CSS/JS](https://img.shields.io/badge/Frontend-HTML%20%7C%20CSS3%20%7C%20JavaScript-F7DF1E?logo=javascript&logoColor=black)](#기술-스택)
[![기간](https://img.shields.io/badge/기간-2024.04–2024.06-6E7781)](#내-역할--성과)  

---

## 📌 프로젝트 개요
- **병원–약국–환자 데이터 통합**으로 의료 경험 혁신 및 효율적 관리  
- **디지털 처방전 관리, 병원/약국 검색, 리뷰 시스템**을 통한 환자 편의성 향상  
- **공공데이터 + Kakao Map API 연계**를 통한 실시간 의료 정보 제공  

---

## 👥 팀원 소개
- 김경민  
- 임회연  
- 변선우  

---

## 📑 목차
- [기술 스택](#기술-스택)
- [화면](#화면)
- [핵심 기능](#핵심-기능)
- [아키텍처](#아키텍처)
- [데이터 모델(ERD)](#데이터-모델erd)
- [API 개요](#api-개요)
- [내 역할 & 성과](#내-역할--성과)

---

## 기술 스택
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1.svg?style=for-the-badge&logo=mysql&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)  
![KakaoMap](https://img.shields.io/badge/API-Kakao%20Map-FFCD00?style=for-the-badge&logo=kakaotalk&logoColor=000000)
![Data.go.kr](https://img.shields.io/badge/API-공공데이터포털-4caf50?style=for-the-badge)

---

## 화면

<table>
  <tr>
    <td align="center">
      <img src="https://github.com/user-attachments/assets/f56524de-8b0c-46f1-925e-387a1aa9c6df" alt="메인 화면" width="240" /><br/>
      <sub>ER 다이어그램</sub>
    </td>
    <td align="center">
      <img src="https://github.com/user-attachments/assets/062385c9-f3bc-496c-b867-fa604a7aaec7" alt="로그인 화면" width="240" /><br/>
      <sub>메인 화면</sub>
    </td>
  </tr>
  <tr>
    <td align="center">
      <img src="https://github.com/user-attachments/assets/d1d74eba-be7c-4143-9e9e-55c1cedc41c0" alt="회원가입 화면1" width="240" /><br/>
      <sub>회원가입 화면1</sub>
    </td>
    <td align="center">
      <img src="https://github.com/user-attachments/assets/393b5f42-22d7-4978-865d-b50e84548374" alt="회원가입 화면2" width="240" /><br/>
      <sub>회원가입 화면2</sub>
    </td>
  </tr>
  <tr>
    <td align="center">
      <img src="https://github.com/user-attachments/assets/5392fc1d-3771-407c-b783-12131b7b70a6" alt="병원 검색" width="240" /><br/>
      <sub>병원 검색</sub>
    </td>
    <td align="center">
      <img src="https://github.com/user-attachments/assets/542d7e0d-a289-46ff-b2f5-f915b0f29a0a" alt="약국 검색" width="240" /><br/>
      <sub>약국 검색</sub>
    </td>
  </tr>
  <tr>
    <td align="center">
      <img src="https://github.com/user-attachments/assets/e2a512ea-c3d7-4ca7-b3fa-b47a970b729b" alt="처방전 관리" width="240" /><br/>
      <sub>처방전 관리</sub>
    </td>
    <td align="center">
      <img src="https://github.com/user-attachments/assets/a1b8da22-b168-4524-9bf0-dbaf0ac775dd" alt="리뷰 시스템" width="240" /><br/>
      <sub>리뷰 시스템</sub>
    </td>
  </tr>
  <tr>
    <td align="center">
      <img src="https://github.com/user-attachments/assets/73d0d014-3052-479c-80fd-f5121f320b78" alt="후기 확인" width="240" /><br/>
      <sub>후기 확인</sub>
    </td>
    <td align="center">
      <img src="https://github.com/user-attachments/assets/eb723816-2589-4681-9984-724ba0a8e056" alt="후기 작성" width="240" /><br/>
      <sub>후기 작성</sub>
    </td>
  </tr>
</table>

---

## 핵심 기능

### 1) 회원별 접근 관리
- 환자, 병원, 약국 역할 기반 회원가입 및 로그인  
- 환자는 처방전 열람/다운로드, 리뷰 작성 가능  
- 병원/약국은 환자 정보 접근 및 처방전 관리  

### 2) 디지털 처방전 관리
- 환자가 안전하게 처방전 업로드 및 다운로드 가능  
- 다운로드 후 DB에서 자동 삭제 → 개인정보 보호  

### 3) 병원/약국 검색 + 리뷰
- Kakao Map API + 공공데이터포털 기반 병원/약국 정보 제공  
- 리뷰 열람 및 작성 가능 → 서비스 개선 활용  

---

## 아키텍처

```mermaid
stateDiagram-v2
  [*] --> Client: 웹 브라우저
  Client --> Backend: HTTP 요청
  Backend --> DB: SQL 쿼리
  Backend --> API1: Kakao Map API 호출
  Backend --> API2: 공공데이터포털 호출
  DB --> Backend
  API1 --> Backend
  API2 --> Backend
  Backend --> Client: 응답 반환

```

---

## 데이터 모델(ERD)
```mermaid
erDiagram
    personal ||--o{ review : writes
    hospital ||--o{ review : receives
    pharmacy ||--o{ review : receives

    personal {
        string p_name
        string p_idnumber
        string p_id
        string p_pw
        string p_sex
        string p_mobile
        int    p_height
        int    p_weight
        string p_disease
    }

    hospital {
        string h_name
        string h_idnumber
        string h_id
        string h_pw
        string h_mobile
        string h_major
        string h_workingaddress
    }

    pharmacy {
        string ph_name
        string ph_idnumber
        string ph_id
        string ph_pw
        string ph_mobile
        string ph_workingaddress
    }

    review {
        string place_name
        string title
        string author
        date   review_date
        string content
        int    rating
    }

```

---
## API 개요

| 메소드    | 경로                     | 설명               |
| ------ | ---------------------- | ---------------- |
| `POST` | `/signup`              | 회원가입             |
| `POST` | `/login`               | 로그인              |
| `GET`  | `/hospitals`           | 병원 검색 (공공데이터 연동) |
| `GET`  | `/pharmacies`          | 약국 검색 (공공데이터 연동) |
| `POST` | `/prescription/upload` | 처방전 업로드          |
| `GET`  | `/prescription/:id`    | 처방전 다운로드         |
| `POST` | `/review`              | 리뷰 작성            |
| `GET`  | `/review/:place`       | 리뷰 조회            |

---

## 내 역할 & 성과

- DB 및 ERD 설계/테이블 구축: Personal, Hospital, Pharmacy, Review 등 주요 테이블 구조 설계 및 관계 정의  
- 데이터 저장 및 처리: 환자/병원/약국/리뷰 데이터 저장 로직 및 SQL 쿼리 작성    
- 병원·약국 위치 검색 기능 구현: Kakao Map API + 공공데이터포털 연동 → 지도 기반 실시간 검색 가능  
- 리뷰/별점 시스템 구현: 특정 지점 검색 시 기존 리뷰 조회 + 후기 작성 및 별점 평가 기능 개발  
- 서비스 통합: 회원가입/로그인 → 병원·약국 검색 → 리뷰/처방전 관리까지 연결되는 전체 플로우 구축  
