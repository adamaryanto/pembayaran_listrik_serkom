# === Aplikasi Pengurutan dan Pencarian Angka ===
# Dibuat untuk simulasi algoritma Sorting & Searching

# Fungsi untuk sorting (menggunakan Bubble Sort)
def sorting(data):
    n = len(data)
    for i in range(n-1):
        for j in range(n-i-1):
            if data[j] > data[j+1]:
                data[j], data[j+1] = data[j+1], data[j]
    return data

# Fungsi untuk searching (Linear Search)
def searching(data, target):
    for i in range(len(data)):
        if data[i] == target:
            return True
    return False

# Program utama
angka = []

while True:
    print("\n=== MENU PILIHAN ===")
    print("1. Input Angka")
    print("2. Sorting")
    print("3. Searching")
    print("4. Selesai")
    pilihan = input("Masukkan pilihan [1/2/3/4]: ")

    if pilihan == '1':
        n = int(input("Masukkan jumlah angka: "))
        angka = []
        for i in range(n):
            nilai = int(input(f"Angka {i+1}: "))
            angka.append(nilai)
        print("Data berhasil diinput:", angka)

    elif pilihan == '2':
        if not angka:
            print("Belum ada data yang diinput!")
        else:
            hasil = sorting(angka.copy())
            print("Hasil Sorting:", hasil)

    elif pilihan == '3':
        if not angka:
            print("Belum ada data yang diinput!")
        else:
            cari = int(input("Masukkan angka yang ingin dicari: "))
            hasil = searching(angka, cari)
            if hasil:
                print("Angka ditemukan!")
            else:
                print("Angka tidak ditemukan!")

    elif pilihan == '4':
        print("Program selesai.")
        break
    else:
        print("Pilihan tidak valid!")
