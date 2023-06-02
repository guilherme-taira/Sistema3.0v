/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package balanca;


 
import jssc.SerialPort;
import jssc.SerialPortException;
/**
 *
 * @author Usuario
 */
public class Balanca {

    /**
     * @param args the command line arguments
     */
      public static void main(String[] args) throws InterruptedException {
  //Parametros estáticos, caso não usem os valores passados por linha de comando
        /*
        int BAUD_RATE =  9600;
        int DATA_BITS = 8;
        int STOP_BITS = 1;
        int PARITY    = 0;
        String SERIAL_PORT = "COM2";
        */
        
        //Armazena os parâmetros nas variáveis
        int BAUD_RATE =  Integer.parseInt(args[0]); //9600
        int DATA_BITS = Integer.parseInt(args[1]); //8
        int STOP_BITS = Integer.parseInt(args[2]); //1
        int PARITY    = Integer.parseInt(args[3]); //0
        String SERIAL_PORT = args[4]; //COM3
        
        String COMANDO ="ENQ"; //Comando inicial, caso nada seja passado como parametro, vai executar um ENQ (muito comum em comunicação serial)
        
        if(args[5].equals("ENQ")){ //Serve apenas para comparar o parâmetro passado e  executar algum comando previamente programado
            
            COMANDO =  ""+(char)5; //Coloquei ""+ (aspas dupla concatenada) só para aceitar como String, pois nem todo comando é do tipo (char) no meu caso
        }
        
        else if(args[5].equals("BEL")){ //Outro comando, e assim vai...
            
            COMANDO =  ""+(char)7+"p";  //Salientando que esses comandos são das minhas necessidades, isso vai depender do comando que o dispositivo esteja aguardando para retornar algo...
        }    
    
        SerialPort serialPort = new SerialPort(SERIAL_PORT);
        
        try {
            //Os comandos "exec" e "passthru" capturam esses retornos, basta exibilos ao seu favor...
            serialPort.openPort();;
            serialPort.setParams(BAUD_RATE, DATA_BITS, STOP_BITS, PARITY);
            serialPort.writeString(""+COMANDO+""); //Aqui ele escreve o comando na porta
            Thread.sleep(1000); //Aguarda 1 segundo para ler a porta
            System.out.println(serialPort.readString()); //Retorno da porta em String
            serialPort.readHexString(""); //Retorno da porta em Hexadecimal, Com "" (aspas dupla) no parâmetro, significa que não haverá espaços entre os valores retornados ou colocando qualquer caractere, servirá como separador.
          
        
        }
        catch (SerialPortException ex){
            System.out.println(ex);
        }
    }   
}
