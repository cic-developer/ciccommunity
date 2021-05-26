document.write('<script src="https://cdnjs.cloudflare.com/ajax/libs/caver-js/1.6.1/caver.min.js"></script>');

function init() {}
const token_abi = [{
        constant: true,
        inputs: [],
        name: "name",
        outputs: [{ name: "", type: "string" }],
        payable: false,
        stateMutability: "view",
        type: "function",
    },
    {
        constant: false,
        inputs: [
            { name: "_spender", type: "address" },
            { name: "_value", type: "uint256" },
        ],
        name: "approve",
        outputs: [{ name: "success", type: "bool" }],
        payable: false,
        stateMutability: "nonpayable",
        type: "function",
    },
    {
        constant: true,
        inputs: [],
        name: "totalSupply",
        outputs: [{ name: "", type: "uint256" }],
        payable: false,
        stateMutability: "view",
        type: "function",
    },
    {
        constant: false,
        inputs: [
            { name: "_from", type: "address" },
            { name: "_to", type: "address" },
            { name: "_value", type: "uint256" },
        ],
        name: "transferFrom",
        outputs: [{ name: "success", type: "bool" }],
        payable: false,
        stateMutability: "nonpayable",
        type: "function",
    },
    {
        constant: true,
        inputs: [],
        name: "decimals",
        outputs: [{ name: "", type: "uint8" }],
        payable: false,
        stateMutability: "view",
        type: "function",
    },
    {
        constant: false,
        inputs: [{ name: "_value", type: "uint256" }],
        name: "burn",
        outputs: [{ name: "success", type: "bool" }],
        payable: false,
        stateMutability: "nonpayable",
        type: "function",
    },
    {
        constant: true,
        inputs: [{ name: "", type: "address" }],
        name: "balanceOf",
        outputs: [{ name: "", type: "uint256" }],
        payable: false,
        stateMutability: "view",
        type: "function",
    },
    {
        constant: false,
        inputs: [
            { name: "_from", type: "address" },
            { name: "_value", type: "uint256" },
        ],
        name: "burnFrom",
        outputs: [{ name: "success", type: "bool" }],
        payable: false,
        stateMutability: "nonpayable",
        type: "function",
    },
    {
        constant: false,
        inputs: [],
        name: "release",
        outputs: [],
        payable: false,
        stateMutability: "nonpayable",
        type: "function",
    },
    {
        constant: true,
        inputs: [],
        name: "owner",
        outputs: [{ name: "", type: "address" }],
        payable: false,
        stateMutability: "view",
        type: "function",
    },
    {
        constant: true,
        inputs: [],
        name: "symbol",
        outputs: [{ name: "", type: "string" }],
        payable: false,
        stateMutability: "view",
        type: "function",
    },
    {
        constant: true,
        inputs: [],
        name: "released",
        outputs: [{ name: "", type: "bool" }],
        payable: false,
        stateMutability: "view",
        type: "function",
    },
    {
        constant: false,
        inputs: [
            { name: "_to", type: "address" },
            { name: "_value", type: "uint256" },
        ],
        name: "transfer",
        outputs: [{ name: "success", type: "bool" }],
        payable: false,
        stateMutability: "nonpayable",
        type: "function",
    },
    {
        constant: true,
        inputs: [{ name: "", type: "address" }],
        name: "frozenAccount",
        outputs: [{ name: "", type: "bool" }],
        payable: false,
        stateMutability: "view",
        type: "function",
    },
    {
        constant: false,
        inputs: [
            { name: "_spender", type: "address" },
            { name: "_value", type: "uint256" },
            { name: "_extraData", type: "bytes" },
        ],
        name: "approveAndCall",
        outputs: [{ name: "success", type: "bool" }],
        payable: false,
        stateMutability: "nonpayable",
        type: "function",
    },
    {
        constant: true,
        inputs: [
            { name: "", type: "address" },
            { name: "", type: "address" },
        ],
        name: "allowance",
        outputs: [{ name: "", type: "uint256" }],
        payable: false,
        stateMutability: "view",
        type: "function",
    },
    {
        constant: false,
        inputs: [
            { name: "target", type: "address" },
            { name: "freeze", type: "bool" },
        ],
        name: "freezeAccount",
        outputs: [],
        payable: false,
        stateMutability: "nonpayable",
        type: "function",
    },
    {
        constant: false,
        inputs: [{ name: "newOwner", type: "address" }],
        name: "transferOwnership",
        outputs: [],
        payable: false,
        stateMutability: "nonpayable",
        type: "function",
    },
    {
        inputs: [
            { name: "initialSupply", type: "uint256" },
            { name: "tokenName", type: "string" },
            { name: "tokenSymbol", type: "string" },
        ],
        payable: false,
        stateMutability: "nonpayable",
        type: "constructor",
    },
    {
        anonymous: false,
        inputs: [
            { indexed: false, name: "target", type: "address" },
            { indexed: false, name: "frozen", type: "bool" },
        ],
        name: "FrozenFunds",
        type: "event",
    },
    {
        anonymous: false,
        inputs: [
            { indexed: true, name: "from", type: "address" },
            { indexed: true, name: "to", type: "address" },
            { indexed: false, name: "value", type: "uint256" },
        ],
        name: "Transfer",
        type: "event",
    },
    {
        anonymous: false,
        inputs: [
            { indexed: true, name: "_owner", type: "address" },
            { indexed: true, name: "_spender", type: "address" },
            { indexed: false, name: "_value", type: "uint256" },
        ],
        name: "Approval",
        type: "event",
    },
    {
        anonymous: false,
        inputs: [
            { indexed: true, name: "from", type: "address" },
            { indexed: false, name: "value", type: "uint256" },
        ],
        name: "Burn",
        type: "event",
    },
];
const token_address = "0x7eee60a000986e9efe7f5c90340738558c24317b";
const PER = new caver.klay.Contract(token_abi, token_address);
const PER_address = "0x0E3A0B94cF7bd745aA8a65Bd707509761e65A832"; //퍼 월렛 주소

$(document).on('ready', async function() {
    const klaytn = window.klaytn;
    if (klaytn === undefined) {
        alert('Klaytn Kaikas가 설치되지 않았습니다.\nKlaytn Kaikas을 설치하여 주세요');
        location.href = "https://m.blog.naver.com/PostView.naver?blogId=djg162&logNo=222063902504&proxyReferer=https:%2F%2Fwww.google.com%2F";
    } else {
        console.log('klaytn : ', klaytn);
    }

    try {

        $(document).on('click', '#charge_button', async function() {
            await klaytn.enable();
            // 클레이튼에 접속되어있는 월렛주소
            const account = klaytn.selectedAddress;
            const balance = await caver.klay.getBalance(account);
            const token_balance = await PER.methods.balanceOf(account).call();

            const network = klaytn.networkVersion;
            const selected_addr = account;
            const per_token = token_balance / 1000000000000000000;

            if (network !== 8217) alert('Klaytn Kaikas의 Network를\nMain network로 바꿔주세요');
            if (!selected_addr) alert('Klaytn Kaikas의 주소를 다시 확인해주세요');
            if (per_token < 0) alert('Klaytn Kaikas에 PER 코인이 없습니다.\nPER 코인을 추가 또는 충전해주세요');

            let charge_value = $('#charge_input').val();
            await klaytn.enable();
            const data = caver.klay.abi.encodeFunctionCall({
                name: "transfer",
                type: "function",
                inputs: [{
                        type: "address",
                        name: "_to",
                    },
                    {
                        type: "uint256",
                        name: "_value",
                    },
                ],
            }, [
                PER_address,
                caver.utils
                .toBN(charge_value)
                .mul(caver.utils.toBN(Number(`1e${18}`)))
                .toString(),
            ]);

            //여기 있는 데이터들로 
            var txhash, reciept, success_fromAddress, success_toAddress, success_value;

            await caver.klay.sendTransaction({
                type: "SMART_CONTRACT_EXECUTION",
                account,
                to: token_address,
                data,
                gas: 3000000,
            }).on("transactionHash", (transactionHash) => {
                // console.log("txHash", transactionHash);
                txhash = `https://scope.klaytn.com/tx/${transactionHash}?tabId=internalTx`;
            }).on("receipt", (receipt) => {
                // console.log("receipt", receipt);
                reciept = JSON.stringify(receipt);
                success_fromAddress = receipt.from;
                success_toAddress = receipt.logs[0].topics[2];
                success_value =
                    caver.utils.hexToNumberString(receipt.logs[0].data) /
                    1000000000000000000;
            }).on("error", (error) => {
                console.log("error", error);
            });

            console.log(txhash, reciept, success_fromAddress, success_toAddress, success_value);
        });
    } catch (error) {
        alert('Klaytn Kaikas연동에 실패 하였습니다. 마이페이지로 이동합니다.');
        console.log(error);
        // location.href = "/mypage";
    }
});